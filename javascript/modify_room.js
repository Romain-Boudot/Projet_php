var current_room_id = document.getElementById('room_id').innerHTML

function send_modification() {
    alert('send modif')
}

function delete_room() {

    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }

    xhr.onreadystatechange = function() {
            
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            validation(xhr.responseText);
        }
        
    }

    xhr.open('POST', '../modules/send_delete_request.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('id=' + current_room_id);
}

// callback of delete_room()
function validation(answer) {

    alert(answer)

    answer = JSON.parse(answer)

    if(answer[0] == 0) {   
        alert("Votre salle a bien été supprimée")
        location.href = "../index.php"
    } else if(answer[0] == 2 ) {
        alert("Votre session a expirée")
        location.href = "../index.php"
    } else {
        alert("Une erreur s'est produite, votre salle n'a pas été supprimée")
    }
    
}