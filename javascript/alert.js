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
    }, 200)

}

function close_popup_alert() {
    document.getElementById('alert_popup').previousElementSibling.nextElementSibling.remove();
}