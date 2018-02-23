<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    //login_test('login');

    //'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/auth_check.php';

    //$action = $_GET['action'];
    //$id = $_GET['id'];

    //$token = gen_token($action, $id);

    //$url = "\"http://" . $_SERVER['HTTP_HOST'] . "/modules/room_action.php?action=" . $action . "&id=" . $id . "&token=" . $token . "\"";

    $url = "\"http://localhost/modules/room_action.php?action=delete&id=56&token=qZDQZdqzdqzdqzdqDQZdqz\"";
 
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
        <style>
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 50px;
            border-radius: 50px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 50px;
            height: 50px;
            background: rgb(75, 75, 75);
            cursor: pointer;
            border-radius: 50px;
        }

        .slider::-moz-range-thumb {
            width: 50px;
            height: 50px;
            background: grey;
            cursor: pointer;
           
        }
        </style>
    </head>

    <body>
    
        <div class="jumbotron" style="text-align: center">
            
            <div class="container">
                <h1 class="display-3">Authentification</h1>
                <p>Vous vous apprêté à supprimé la room.<p>
            </div>
            
            <div class="container">

                <div class="slidecontainer" method="post">
                    <input id="captcha" type="range" min="1" max="100" class="slider" id="myRange" value="1">
                </div>   
                <div id="linkid">    
                    <a class="btn btn-primary btn-lg" href=<?php echo $url; ?> role="button">Accepter</a>
                </div>
                
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

                <script>
                
                    $("#captcha").change(function(){

                        var value = $("#captcha").val()

                        if (value == 100) {

                            alert('ouiiiiiiii')

                        }
                         
                        if (value < 100)
                    {
                        $("#captcha").val(0)
                    } 
                        var link = $("#link").innerHTML = <a class="btn btn-primary btn-lg" href=<?php echo $url; ?> role="button">Accepter</a>
                    })

                </script>
            
            </div>    

        </div>

    </body>

</html>


