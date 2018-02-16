<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    //login_test('login');

    //'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/auth_check.php?token=XXXXXXXXXX&'

    //$GURL = $_GET['url'];

    //$token = gen_token($GURL);

    //$url = "\"" . $URL . "&token=" . $token . "\"";

    $url = "\"http://localhost/modules/room_action.php?action=delete&id=56&token=qZDQZdqzdqzdqzdqDQZdqz\""
 
    //"http://localhost/talk_with_me/auth_check.php?url=http://localhost/modules/room_action.php?action=delete%26id=56"



?>

<!DOCTYPE html>

<html>

    <head>

        <title>Authentification</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <!--link rel="stylesheet" href="../css/404.css"-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <link rel="stylesheet" href="auth_check.css">
    </head>

    <body>
    
        <div class="jumbotron" style="text-align: center">
            
            <div class="container">
                <h1 class="display-3">Authentification</h1>
            </div>
            
            <div class="slidecontainer">
                <input type="range" min="1" max="100" class="slider" id="myRange">
                <a class="btn btn-primary btn-lg" href=<?php echo $url; ?> role="button">Accepter</a>
            </div>    
        
        </div>

    </body>

</html>
