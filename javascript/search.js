var xhr
var invited_users = []
var current_user_id = document.getElementById('current_id').textContent

if(window.XMLHttpRequest || window.ActiveXObject) {

    if(window.ActiveXObject) {
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
    } else {
        xhr = new XMLHttpRequest(); 
    }

} else {

    alert("Votre navigateur ne supporte pas l'XMLhttpRequest")

}

function show_result(array_users) {
    
    document.getElementById("search_element").innerHTML=""
    users = JSON.parse(array_users)
    
    if (users.length > 0) {
        
        if(users[0][0] == -1) {
            var div = document.createElement("div")
            div.innerHTML = "trop de résultats"
            document.getElementById("search_element").appendChild(div)
            document.getElementById("search_result").style.display = "block"
            return
        }
        
        for(var i = 0; i < users.length; i++) {

            if(users[i][0] == current_user_id) continue
            
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
        
        document.getElementById("search_result").style.display = "block"
        
    } else {
        
        var div = document.createElement("div")
        div.
        div.innerHTML = "Aucun utilisateur ne correspond à votre recherche."
        document.getElementById("search_element").appendChild(div)
        
    }
    
}

function search_db(search_key_word) {
    
    if (search_key_word != '') {
        
        if (xhr && xhr.readyState != 0) {
            xhr.abort()
        }
        
        xhr.onreadystatechange = function() {
            
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                show_result(xhr.responseText);
            }
            
        }
        
        xhr.open("GET", "../modules/search_request.php?search=" + search_key_word, true);
        xhr.send(null);
        
    } else {
        
        if (xhr && xhr.readyState != 0) {
            xhr.abort()
        }
        
        document.getElementById("search_element").innerHTML=""
        document.getElementById("search_result").style.display = "none"
        
    }
    
}

function add_user(target) {

    for(var i = 0; i < invited_users.length; i++) {
        if(invited_users[i] == target.id) return
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

            return
        }
    }

    if(parent.childElementCount == 1) {
        document.getElementById('nobody_added').style.display = "block"
    }

    /* impossible ! */

}

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