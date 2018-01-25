
// fonction qui appele une requete sql via php

function send_creation() {


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
        location.href = "../../index.php" // redirection vers l'accueil 

    } else if(answer[0] == 2 ) {

        alert("Votre session a expirée")
        location.href = "../../index.php" // redirection vers l'accueil 

    } else {

        alert("Une erreur s'est produite, votre salle n'a pas été créée")

    }
    
}