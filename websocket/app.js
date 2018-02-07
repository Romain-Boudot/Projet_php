
const http = require('http');
const fs = require('fs');
const mysql = require('mysql');

const bdd = mysql.createConnection({

    host     : 'localhost',
    user     : 'webclient',
    password : 'webpassword',
    database : 'projet_php'

});

bdd.connect();

// load du index pour le client qui se connect

const server = http.createServer(function(req, res) {

    fs.readFile('./index.html', 'utf-8', function(error, content) {

        res.writeHead(200, {"Content-Type": "text/html"});

        res.end(content);

    });

});


// Chargement de socket.io

const io = require('socket.io').listen(server);

io.sockets.on('connection', function (client) {

    var header = JSON.stringify(client.handshake.headers.referer).split('/')
    var user = {
        'room'      : header[header.length - 4],
        'login'     : header[header.length - 3],
        'serverid'  : header[header.length - 2],
        'socketid'  : client.id,    
        'token'     : header[header.length - 1],
    };
    
    // message lors d'une nouvelle connection
    console.log('new log in room ' + user.room);
    client.emit('connected', {
        'login'     : user.login,
        'room'      : user.room
    });
    
    send_old_message(user, client);

    client.join(user.room);

    client.on('message', function(data) {
        
        send_msg(data, client, user);
    
    })

    client.on('disconnect', function() {

        console.log(user.login + " disconnected");

    })

});


function send_msg(data, client, user) {

    var now = new Date();

    var year = now.getFullYear();
    var mon  = now.getMonth();      if (mon < 10) mon = '0' + mon;
    var day  = now.getDay();        if (day < 10) day = '0' + day;

    var hour = now.getUTCHours();   if (hour < 10) hour = '0' + hour;
    var min  = now.getMinutes();    if (min < 10) min = '0' + min;
    var sec  = now.getSeconds();    if (sec < 10) sec = '0' + sec;

    var date = year + '-' + mon + '-' + day + ' ' + hour + ':' + min + ':' + sec;

    insert_into('INSERT INTO message SET ?', {
        'roomid'    : user.room,
        'authorid'  : user.serverid,
        'content'   : data,
        'date'      : date
    }, false);

    var html = message_html(date, user.login, user.serverid, data);

    client.to(user.room).emit('message', html);
    client.emit('message', html);

}


// base de donnée
function insert_into(sql, value) {
   
    bdd.query(sql, value, function (err, result, fields) {

        if (err) throw err;

    });
    
}

function send_old_message(user, client) {

    var sql = "SELECT m.id as id, roomid, u.login as author, u.id as userid, content, date as message_date FROM message m JOIN users u on m.authorid = u.id WHERE roomid = ? ORDER BY date asc LIMIT 0 , 50"

    bdd.query(sql, user.room, function (err, result, fields) {

        if (err) throw err;
        result.forEach(element => {

            client.emit('message', message_html(element.message_date, element.author, element.id, element.content));
        
        });

    });

}


function message_html(message_date, login, id, content) {
    return '<div class="container-fluid bg-light p-3 rounded">' + 
    '<span class="font-weight-light pr-2 text-little">' + message_date + '</span>' +
    '<span class="text-danger border border-bottom-0 border-top-0 border-left-0 border-secondary pr-2 mr-2">' + login + '#' + id + '</span>' +
    content + '</div><br>';
}

// ouverture du websocket
server.listen(8080);