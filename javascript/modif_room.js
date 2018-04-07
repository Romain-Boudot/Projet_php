var invited_users;
var current_room_id = document.getElementById('room_id').value
var current_user_id = document.getElementById('current_id').value

// ajoute un utilisateur a partir de la recherche


function add_user(target) {

    for (var i = 0; i < invited_users.length; i++) {
        if (invited_users[i] == target.id) return
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

    for (var i = 0; i < invited_users.length; i++) {

        if (invited_users[i] == target.id) {

            // we delete the user id of the invited list
            invited_users.splice(i, 1);

            // we delete the div element of the users to the invited list of users
            parent.removeChild(target)

        }

    }

    if (parent.childElementCount == 1) {
        document.getElementById('nobody_added').style.display = "block"
    }

}

// fonction qui appele une requete sql via php

function send_creation() {

    xhr = getXMLHTTP()

    // récuperation du nom de la salle à créer

    data = document.getElementById('name').value


    // si le nom est vide inform l'utilisateur et stop la requete

    if (data == '') {
        alert('Veuillez entrer un nom pour votre salle')
        return
    }


    // mise en forme pour l'envie via GET / URI 

    data = "id=" + current_room_id + "&name=" + data + "&user="

    // ajoue a l'URI des utilisateur à inviter

    for (var i = 0; i < invited_users.length; i++) {
        if (i > 0) data += ";"
        data += invited_users[i]
    }

    console.log(data)

    // si une requete à déjà été envoié au serveur, l'annule

    if (xhr && xhr.readyState != 0) {
        xhr.abort()
    }


    // sur réponse du serveur on éxécute la fonction de callback avec en parametre la réponse du la page php

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            console.log(xhr.responseText);
            creation_callback(JSON.parse(xhr.responseText));
        }

    }


    // ouvre une requete de type 'POST' asynchrone vers le module send_creation_request.php
    // encodage de l'url
    // envoie de la requete

    xhr.open('POST', '../../modules/send_modif_request.php', true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}


// callback de send_creation()

function creation_callback(answer) {

    // la page php renvoie l'état de la requete sous forme JSON

    console.log(answer)

    // alert de l'utilisateur en fonction de la réponse à la requete
    // 0 - créé
    // 1 - erreur inconnue
    // 2 - session expiré

    if (answer[0] == 0) {

        popup_alert("Votre salle a bien été modifiée", 'green', 'check', '/')

    } else if (answer[0] == 2) {

        popup_alert("Votre session a expirée", 'green', 'check', '/')

    } else {

        popup_alert("Une erreur s'est produite, votre salle n'a pas été modifiée", 'green', 'check', '/')

    }

}

function get_allready_invited(id) {

    xhr = getXMLHTTP()

    data = 'id=' + id;

    // sur réponse du serveur on éxécute la fonction de callback avec en parametre la réponse du la page php

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {

            var answer = (JSON.parse(xhr.responseText))

            invited_users = answer[0];

            for (var cpt = 0; cpt < invited_users.length; cpt++) {

                if (invited_users[cpt] == current_user_id) continue;

                var newdiv = document.createElement("div")
                newdiv.id = invited_users[cpt]
                newdiv.setAttribute("onclick", "del_user(this)")
                newdiv.innerHTML = '<button type="button" class="close" onclick="del_user(this)" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    answer[1][cpt][0] + " - " +
                    answer[1][cpt][1] + " - " +
                    answer[1][cpt][2]

                document.getElementById('nobody_added').style.display = "none"

                document.getElementById('invited_users').appendChild(newdiv)

            }

        }

    }


    // ouvre une requete de type 'POST' asynchrone vers le module send_creation_request.php
    // encodage de l'url
    // envoie de la requete

    xhr.open('GET', '../../modules/get_invited_users.php?' + data, true);
    //xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();

}

$(document).ready(function () {

    get_allready_invited(current_room_id);

})