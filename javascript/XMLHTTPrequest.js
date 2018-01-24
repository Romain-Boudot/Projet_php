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