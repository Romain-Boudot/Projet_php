function popup_alert(message) {

    document.body.innerHTML += "<div id='alert_popup' style='opacity:0' class='alert-bg'>" +
        "<div style='opacity:0' class='alert'><div class='alert-content'>" +
        message +
        "</div><div class='alert-footer'>" +
        "<div class='icon-wrapper red clickable' onclick='close_popup_alert()'>" +
        "<i class='material-icons'>close</i></div></div></div></div>";

    setTimeout(function() {
        document.getElementById('alert_popup').style = 'opacity:1';
        document.getElementById('alert_popup').firstElementChild.style = 'opacity:1';
    }, 10)

    callback;

}

function popup_create_room() {
    document.getElementById('roomcreation').style = 'display:block;opacity:0';
    setTimeout(function(){
        document.getElementById('roomcreation').style = 'display:block;opacity:1';
    }, 10);
}

function close_popup_alert() {
    document.getElementById('alert_popup').style = 'opacity:0';
    setTimeout(function() {
        document.getElementById('alert_popup').remove();
    }, 200)
}

function close_create_room() {
    document.getElementById('roomcreation').style = 'display:block;opacity:0';
    setTimeout(function(){
        document.getElementById('roomcreation').style = 'display:none;opacity:0';
    }, 200);
}