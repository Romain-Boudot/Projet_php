room_id = document.getElementById('current_room').innerHTML

innermessage = new EventSource("../modules/message.php")

innermessage.onmessage = function(data) {

    var div = document.createElement("div")
    div.innerHTML = "erreur"

    document.getElementById("messages_container").appendChild(div)

}

innermessage.addEventListener("room_target:" + room_id, function(data) {

    var div = document.createElement("div")
    div.innerHTML = data.data

    document.getElementById("messages_container").appendChild(div)

})