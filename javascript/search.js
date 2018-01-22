var xhr
var invited_users = []
var current_user_id = document.getElementById('current_id').innerHTML

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

// callback of search_db
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