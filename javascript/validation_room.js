function getXMLHTTP() {

    
    // vérifie si le module 'xhr' est supporter

    if(window.XMLHttpRequest || window.ActiveXObject) {
        
        if(window.ActiveXObject) {

            try {

                var xhr = new ActiveXObject("Msxml2.XMLHTTP");
                return xhr

            } catch(e) {

                var xhr = new ActiveXObject("Microsoft.XMLHTTP");
                return xhr

            }

        } else {

            var xhr = new XMLHttpRequest(); 
            return xhr

        }
        
    } else {


        // sinon alerter l'utilisateur que son navigateur ne le supporte pas
        
        alert("Votre navigateur ne supporte pas l'XMLhttpRequest")
        
    }
    
}


function accept(id) {


    data = "id=" + id


    xhr = getXMLHTTP()


    // si une requete à déjà été envoié au serveur, l'annule
    
    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }


    // sur réponse du serveur on éxécute la fonction de callback avec en parametre la réponse du la page php
    
    xhr.onreadystatechange = function() {
            
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            accept_callback(xhr.responseText, id);
        }
        
    }


    // ouvre une requete de type 'POST' asynchrone vers le module accept_invitation.php
    // encodage de l'url
    // envoie de la requete

    xhr.open('POST', 'modules/accept_invitation.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);

}


function accept_callback(answer, deleteid) {


    // retourne les erreur à l'utilisateur

    if (answer == 2) { alert('votre session a expirer'); return; }
    else if (answer == 1) { alert('une erreur est survenue'); return; }


    // suprime l'ancienne dive et la remplace par la nouvelle si aucune erreur n'a été reporter

    var parent = document.getElementById('room_container');
    var old = document.getElementById('id' + deleteid);
    parent.removeChild(old);

    document.getElementById('room_container').innerHTML = answer + document.getElementById('room_container').innerHTML

}

function refuse(id) {


    data = "id=" + id


    xhr = getXMLHTTP()


    // si une requete à déjà été envoié au serveur, l'annule
    
    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }


    // sur réponse du serveur on éxécute la fonction de callback avec en parametre la réponse du la page php
    
    xhr.onreadystatechange = function() {
            
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            refuse_callback(xhr.responseText, id);
        }
        
    }


    // ouvre une requete de type 'POST' asynchrone vers le module accept_invitation.php
    // encodage de l'url
    // envoie de la requete

    xhr.open('POST', 'modules/refuse_invitation.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);

}

function refuse_callback(answer, deleteid) {


    // retourne les erreur à l'utilisateur

    if (answer == 2) { alert('votre session a expirer'); return; }
    else if (answer == 1) { alert('une erreur est survenue'); return; }


    // suprime l'ancienne dive et la remplace par la nouvelle si aucune erreur n'a été reporter

    var parent = document.getElementById('room_container');
    var old = document.getElementById('id' + deleteid);
    parent.removeChild(old);

}