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

// requete pour recherche d'utilisateur sur la base de donnée 

function search_db(search_key_word) {


    xhr = getXMLHTTP() // récuperation de l'objet xhr


    // si la recherche n'est pas vide
    
    if (search_key_word != '') {


        // annule la requete en cours si il y en a une
        
        if (xhr && xhr.readyState != 0) {
            xhr.abort()
        }


        // lors de la reception de la réponse éxécute la fonction de callback show_result(' la réponse de la requete ')
        
        xhr.onreadystatechange = function() {
            
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                show_result(xhr.responseText);
            }
            
        }

        
        // ouvre une requete xhr vers le module search_request.php en GET avec comme parametre le but de la recherche
        // pouis l'envoie

        xhr.open("GET", "../../modules/search_request.php?search=" + search_key_word, true);
        xhr.send(null);
        
    } else { // si la recherche est vide


        // annule la requete en cours
        
        if (xhr && xhr.readyState != 0) {
            xhr.abort()
        }
        

        // vide la section de résultat de recherche
        // cache la section de resultat de recherche

        document.getElementById("search_element").innerHTML=""
        document.getElementById("search_result").style.display = "none"
        
    }
    
}


// callback de search_db

function show_result(array_users) {


    // on vide la recherche
    
    document.getElementById("search_element").innerHTML=""
    
    
    // la requete renvoie un objet JSON donc on parse

    users = JSON.parse(array_users)
    

    // si il y a une réponse

    if (users.length > 0) {
        

        // si la réponse est -1, il a trop de reponse, on informe l'utilisateur

        if(users[0][0] == -1) {


            var div = document.createElement("div")
            div.innerHTML = "trop de résultats"
            document.getElementById("search_element").appendChild(div)
            document.getElementById("search_result").style.display = "block"
            return
        
            
        }

        
        for(var i = 0; i < users.length; i++) {


            // si c'est l'utilisateur actuellement log on passe

            if(users[i][0] == current_user_id) continue


            // on creer la div dans la section de resultat de recherche
            
            var div = document.createElement("div")
            div.id = users[i][0];
            div.setAttribute("onclick", "add_user(this)")
            div.setAttribute("class", "clickable")
            div.setAttribute("data-login", "" + users[i][1])
            div.setAttribute('data-last_name', "" + users[i][2])
            div.setAttribute('data-first_name', "" + users[i][3])
            div.innerHTML = "<span class='mr-1 badge badge-secondary'>+</span>" + 
                users[i][1] + " - " + users[i][2] + " - " + users[i][3]
            document.getElementById("search_element").appendChild(div)
            
        }
        

        // on affcihe la section de resultat de recherche

        document.getElementById("search_result").style.display = "block"
        
    } else {
        

        // on affiche qu'un aucun utilisateur n'a été trouver

        var div = document.createElement("div")
        div.innerHTML = "Aucun utilisateur ne correspond à votre recherche."
        document.getElementById("search_element").appendChild(div)
        
    }
    
}