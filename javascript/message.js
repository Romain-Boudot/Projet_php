var invited_users = []
var current_room_id = document.getElementById('room_id').innerHTML
var current_user_id = document.getElementById('current_id').innerHTML


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


room_id = document.getElementById('current_room').innerHTML


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


document.getElementById('message').onkeypress = function(key) {

    if (key.keyCode == 13) send_message()

}


var moment = setInterval(function(){

    pull_message();

}, 1000)


function send_message() {

    
    content = document.getElementById('message').value
    document.getElementById('message').value = ''

    xhr = getXMLHTTP();


    if (content != '') {

        data = "roomid=" + room_id + "&content=" + content

        // lors de la reception de la réponse éxécute la fonction de callback show_result(' la réponse de la requete ')
        
        xhr.onreadystatechange = function() {
            

            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                validation(xhr.responseText);
            }
            
        }

        
        // ouvre une requete xhr vers le module search_request.php en GET avec comme parametre le but de la recherche
        // pouis l'envoie

        xhr.open("POST", "../modules/send_message.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
        
    } else { // si le contenue est vide
        

        alert('Votre message est vide')
        
    }

}


function validation(answer) {

    if (answer == 1) alert('Une erreur est survenue')

    if (answer == 2) alert('Votre session a expirer')

}

function pull_message() {


    xhr = getXMLHTTP();

        
    xhr.onreadystatechange = function() {
        

        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            add_message(xhr.responseText);
        }
        
    }


    xhr.open("POST", "../modules/message.php?id=" + room_id, true);
    xhr.send(null);

}


function add_message(answer) {

    document.getElementById('messages_container').innerHTML += answer

}