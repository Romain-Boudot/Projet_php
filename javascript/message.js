var ws = new WebSocket('ws://localhost:8080');

function send_message() {
    
    var content = document.getElementById('message').value
    document.getElementById('message').value = ''

    if (content != '') {

        var current_user_id = document.getElementById('current_id').value
        var token = document.getElementById('tokenUser').value

        ws.send('msg\\' + token + '\\' + content)
        
    } else { // si le contenue est vide

        popup_alert('Votre message est vide', 'green', 'check', '')
        
    }

}

function on_blur(target) {

    target.setAttribute("contenteditable", "false");
    var content = target.innerHTML
    send_edit(content, $(target).attr('id'))

}

function on_key_press(key, target) {

    if (key.keyCode == 13) {
        target.blur();
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

function del(id) {

    var current_user_id = document.getElementById('current_id').value
    var token = document.getElementById('tokenUser').value

    ws.send("del\\" + token + "\\" + id);

}

function edit(id) {

    document.getElementById('contentid' + id).setAttribute("contenteditable", "true");
    document.getElementById('contentid' + id).focus();

}

function send_edit(content, id) {

    var token = document.getElementById('tokenUser').value
    id = id.slice(9)
    ws.send('edt\\' + token + '\\' + id + '\\' + content);

}

ws.onopen = function() {

    var current_room_id = document.getElementById('current_room').value
    var current_user_id = document.getElementById('current_id').value
    var token = document.getElementById('tokenUser').value

    ws.send('jon\\' + current_room_id + '\\' + current_user_id + '\\' + token);

}

ws.onerror = function(e) {
    popup_alert('une erreur est survenue', 'green', 'check', '');
}

ws.onmessage = function(data) {

    console.log(data.data);

    data = JSON.parse(data.data);

    // -1 info
    // -2 delete
    // -3 edit
    // 0 msg normal
    // 1 msg cacher
 
    if (data[0] == -1) {

        console.log(data[1]);

    } else if (data[0] == -2) {

        document.getElementById(data[1]).nextElementSibling.remove();
        document.getElementById(data[1]).remove();

    } else if (data[0] == -3) {
            
        document.getElementById('contentid' + data[1]).innerText = data[3];
        
    } else if (data[0] == 0 || data[0] == 1) {
        
        document.getElementById('messages_container').innerHTML += data[1];        
        
        if (data[0] == 0) {

            var notification = new Notification(' MARCASSIN',{body: 'Vous avez réçu un nouveau message' } );
            notification.onshow = function () { 
                setTimeout(notification.close.bind(notification), 5000); 
            }

        }

    }

    window.scrollBy(0, 9999999);

}

window.scrollBy(0, 9999999);