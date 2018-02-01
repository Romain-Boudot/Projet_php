
var http = require('http');
var fs = require('fs');
var mysql = require('mysql');

var bdd = mysql.createConnection({

    host     : 'localhost',
    user     : 'webclient',
    password : 'webpassword',
    database : 'projet_php'

});

// load du index pour le client qui se connect

var server = http.createServer(function(req, res) {

    fs.readFile('./index.php', 'utf-8', function(error, content) {

        res.writeHead(200, {"Content-Type": "text/html"});

        res.end(content);

    });

});


// Chargement de socket.io

var io = require('socket.io').listen(server);

io.sockets.on('connection', function (socket) {


    // message lors d'une nouvelle connection
    console.log('new log');
    socket.emit('connected', null);


    socket.on('new_msg', function(data) {

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