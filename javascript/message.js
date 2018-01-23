function send_message() {
    message = document.getElementById('message').value
    document.getElementById('message').value = ''
    newmessage = document.createElement('div')
    newmessage.className = "container-fluid w-100 bg-dark text-light"
    newmessage.innerHTML = message
    document.getElementById('message_container').appendChild(newmessage)
}