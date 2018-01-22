var allready_invited = []

get_allready_invited_users()

function get_allready_invited_users() {

    var temp = document.getElementById('invited_users').children

    if(temp.length <= 1) {
        return
    }
    
    for(var i = 0; i < (temp.length -2 ); i++) {

        allready_invited[allready_invited.length] = temp[i].id

    }
    
}

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

function expulse_user(target) {
    
    for(var i = 0; i < expulsed_users.length; i++) {
        if(invited_users[i] == target.id) return
    }

    

}

function unexpulse_user(target) {
    
}