// used in 
// 
//


// fonction triggered quand on load la page

window.onload = function() {
    get_allready_invited_users()
}
    

// récupere les utilisateur deja dans la salleactuelle

function get_allready_invited_users() {


    // par récuperation de tout les enfant de invited_users

    var temp = document.getElementById('invited_users').children

    if(temp.length <= 1) {
        return
    }
    

    // on les ajoute un par un dans allready_invited

    for(var i = 0; i < (temp.length -2 ); i++) {

        allready_invited[allready_invited.length] = temp[i].id

    }
    
}

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

    xhr.open('POST', '../../modules/send_delete_request.php', true);
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