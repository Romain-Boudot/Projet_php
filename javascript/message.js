var ws = new WebSocket('ws://localhost:8080');

function send_message() {
    
    var content = document.getElementById('message').value
    document.getElementById('message').value = ''

    if (content != '') {

        var current_user_id = document.getElementById('current_id').value
        var token = document.getElementById('tokenUser').value

        ws.send('msg\\' + current_user_id + '\\' + token + '\\' + content)
        
    } else { // si le contenue est vide

        alert('Votre message est vide')
        
    }

}

window.addEventListener('load', function () {
    Notification.requestPermission(function (status) {
        Notification.permission = status;
    });
});

document.getElementById('message').onkeypress = function(key) {

    if (key.keyCode == 13) send_message()

}



ws.onopen = function() {

    var current_room_id = document.getElementById('current_room').value
    var current_user_id = document.getElementById('current_id').value
    var token = document.getElementById('tokenUser').value

    ws.send('jon\\' + current_room_id + '\\' + current_user_id + '\\' + token);

}

ws.onmessage = function(data) {

    console.log(data.data);

    data = JSON.parse(data.data);
 
    if (data[0] == -1) {

        console.log(data[1]);

    } else {
        
        document.getElementById('messages_container').innerHTML += data[1];        
        
        if (data[0] == 0) {
            var notification = new Notification(' MARCASSIN',{body: 'Vous avez réçu un nouveau message' } );
            notification.onshow = function () { 
                setTimeout(notification.close.bind(notification), 5000); 
            }
        }
    }

}