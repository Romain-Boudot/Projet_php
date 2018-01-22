function send_creation() {

    data = document.getElementById('name').value

    if(data == '') {
        alert('Veuillez entrer un nom pour votre salle')
        return
    }

    data = "name=" + data + "&user="

    for(var i = 0; i < invited_users.length; i++) {
        if(i > 0) data += ";"
        data += invited_users[i]
    }

    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }

    xhr.onreadystatechange = function() {
            
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            validation(xhr.responseText);
        }
        
    }

    xhr.open('POST', '../modules/send_creation_request.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}

// callback of send_creation()
function validation(answer) {

    alert(answer)

    answer = JSON.parse(answer)

    if(answer[0] == 0) {   
        alert("Votre salle a bien été créée")
        location.href = "../index.php"
    } else if(answer[0] == 2 ) {
        alert("Votre session a expirée")
        location.href = "../index.php"
    } else {
        alert("Une erreur s'est produite, votre salle n'a pas été créée")
    }
    
}