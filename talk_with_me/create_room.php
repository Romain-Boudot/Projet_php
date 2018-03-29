<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, userscalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../../main.css">
    <title>Création de salle</title>

</head>

<body class="pt-80px">

    <div id="current_id" hidden><?php echo $_SESSION['user']['id']; ?></div>
    <div id="room_id" hidden>-1</div>
    
    <nav class="navbar fixed-top navbar-dark bg-dark blue-shadow">
        <div class="d-flex">
            <span id="btn_slide_menu_trigger" style="font-size: 100%" class="text-light clickable fas fa-bars"></span>
            <a class="resp-640-hd navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>
        </div>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['user']['login']; ?></span>
            <a class='btn btn-outline-secondary ml-4 resp-640-hd' href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php" role="button">Créer une salle</a>
            <a class="btn btn-outline-secondary ml-2 resp-640-hd" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>

    <div id="slide_menu" class="container bg-dark pt-2 text-center">
        <ul>
            <li><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>Accueil</a></li>
            <li class="active"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php">Créer une salle</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php">Déconnexion</a></li>
        </ul>
    </div>

    <div id="creation_container" class="container mw-900">

        <div class='container border rounded p-4 text-center bg-light'>

            <h2>Création de salle</h2>

            <hr>
            <br>

            <div class="container">

                <label class="resp-label-572">Nom de la salle</label>
                <div class="input-group mb-3 resp-572-rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input type="text" id="name" class="form-control" maxlength="30" placeholder="random things"/>
                </div>

                <label class="resp-label-572">Nom d'Utilisateur</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend resp-572-rounded">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon2" style="width: 180px;">Recherche d'utilisateur</span>
                    </div>
                    <input id="search" type="text" class="form-control" placeholder="Pseudo" onkeyup="search_db(this.value)"/>
                </div>

                <div id="search_result" class="p-2 border text-left mb-1" style="display: none">
                    <div id="search_result_title">Résultats de la recherche<hr></div>
                    <div id="search_element"></div>
                </div>

                <div id="invited_users" class="container p-3 w-100 border text-left">
                    <div id="nobody_added" style="display: block">Vous n'avez ajouté personne dans votre salle.</div>
                </div>

                <a role="button" class="btn btn-secondary mr-3 mt-3" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Annuler</a>
                <button type="button" onclick="send_creation()" class="btn btn-primary mt-3">Créer</button>

            </div>

        </div>

    </div>

    <script src="../../javascript/search.js"></script>
    <script src="../../javascript/create_room.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
    
        $(document).ready(function(){

            $('#btn_slide_menu_trigger').on("click", function() {
                console.log($('#slide_menu').css("transform"))
                if ($('#slide_menu').css("transform") == 'none') {
                    $('#slide_menu').css("transform", "translateX(210px)")
                } else {
                    $('#slide_menu').css("transform", "none")
                }
            })

        })
    
    </script>

</body>


</html>