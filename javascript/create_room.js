var invited_users = []
var current_room_id = document.getElementById('room_id').innerHTML
var current_user_id = document.getElementById('current_id').innerHTML

// ajoute un utilisateur a partir de la recherche 
var allready_invited = []

function add_user(target) {

    for(var i = 0; i < invited_users.length; i++) {
        if(invited_users[i] == target.id) return
    }
    
    for(var i = 0; i < allready_invited.length; i++) {
        if(allready_invited[i] == target.id) return
    }


    // we add the user id to the invited list
    
    invited_users[invited_users.length] = target.id
    

    // we copy the information of the clicked id to create a new one in the invited list of user
    
    var newdiv = document.createElement("div")
    newdiv.id = target.id
    newdiv.setAttribute("onclick", "del_user(this)")
    newdiv.innerHTML = '<button type="button" class="close" onclick="del_user(this)" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        target.getAttribute('data-login') + " - " +
        target.getAttribute('data-last_name') + " - " +
        target.getAttribute('data-first_name')

    document.getElementById('nobody_added').style.display = "none"

    document.getElementById('invited_users').appendChild(newdiv)

}

function del_user(target) {

    target = target.parentElement
    parent = document.getElementById('invited_users')

    for(var i = 0; i < invited_users.length; i++) {

        if(invited_users[i] == target.id) {

            // we delete the user id of the invited list
            invited_users.splice(i, 1);

            // we delete the div element of the users to the invited list of users
            parent.removeChild(target)
            
        }
        
    }

    if(parent.childElementCount == 1) {
        document.getElementById('nobody_added').style.display = "block"
    }

}
// fonction de récuperation de l'objet XMLHTTPrequest ( xhr )

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

// fonction qui appele une requete sql via php

function send_creation() {

    xhr = getXMLHTTP()

    // récuperation du nom de la salle à créer
    
    data = document.getElementById('name').value


    // si le nom est vide inform l'utilisateur et stop la requete
    
    if(data == '') {
        alert('Veuillez entrer un nom pour votre salle')
        return
    }


    // mise en forme pour l'envie via GET / URI 
    
    data = "name=" + data + "&user="


    // ajoue a l'URI des utilisateur à inviter
    
    for(var i = 0; i < invited_users.length; i++) {
        if(i > 0) data += ";"
        data += invited_users[i]
    }


    // si une requete à déjà été envoié au serveur, l'annule
    
    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }


    // sur réponse du serveur on éxécute la fonction de callback avec en parametre la réponse du la page php
    
    xhr.onreadystatechange = function() {
            
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            creation_callback(xhr.responseText);
        }
        
    }


    // ouvre une requete de type 'POST' asynchrone vers le module send_creation_request.php
    // encodage de l'url
    // envoie de la requete

    xhr.open('POST', '../../modules/send_creation_request.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}


// callback de send_creation()

function creation_callback(answer) {

    // la page php renvoie l'état de la requete sous forme JSON

    answer = JSON.parse(answer)


    // alert de l'utilisateur en fonction de la réponse à la requete
    // 0 - créé
    // 1 - erreur inconnue
    // 2 - session expiré

    if(answer[0] == 0) {

        alert("Votre salle a bien été créée")
        location.href = "../index.php" // redirection vers l'accueil 

    } else if(answer[0] == 2 ) {

        alert("Votre session a expirée")
        location.href = "../index.php" // redirection vers l'accueil 

    } else {

        alert("Une erreur s'est produite, votre salle n'a pas été créée")

    }
    
}