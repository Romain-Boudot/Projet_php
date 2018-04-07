function popup_alert(message, color, btn, redirect) {

    document.body.innerHTML += "<div id='alert_popup' style='opacity:0' class='alert-bg'>" +
        "<div style='opacity:0' class='alert'><div class='alert-content'>" +
        message +
        "</div><div class='alert-footer'>" +
        "<div class='icon-wrapper " + color + " clickable' onclick='close_popup_alert(\"" + redirect + "\")'>" +
        "<i class='material-icons'>" + btn + "</i></div></div></div></div>";

    setTimeout(function() {
        document.getElementById('alert_popup').style = 'opacity:1';
        document.getElementById('alert_popup').firstElementChild.style = 'opacity:1';
    }, 10)

}

function close_popup_alert(redirect) {
    
    document.getElementById('alert_popup').style = 'opacity:0';
    setTimeout(function() {
        document.getElementById('alert_popup').remove();
        if (redirect != "") {
            location.href = redirect;
        }
    }, 200)

}