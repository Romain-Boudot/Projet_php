
const http = require('http');
const fs = require('fs');
const mysql = require('mysql');

const bdd = mysql.createConnection({

    host     : 'localhost',
    user     : 'webclient',
    password : 'webpassword',
    database : 'projet_php'

});

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
    header = header[header.length - 1].slice(0, -1)
    // message lors d'une nouvelle connection
    console.log('new log in room ' + header);
    client.emit('connected', header);


    client.on('new_msg', function(data) {

        new_message(data);
    
    })

});


// base de donnée



bdd.connect(function(error) { // connecion à la base de donnée

    if (error) throw error;
    console.log("connected to the data-base");

});



// ouverture du websocket
server.listen(8080);