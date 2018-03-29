<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // check si une session est en cours, si non redirige vers #login
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
    <link rel="stylesheet" href="main.css">
    <title>Talk with me!</title>
      
</head>

<body class="pt-80px pb-80px">
    
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
            <li class="active"><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>Accueil</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php">Créer une salle</a></li>
            <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php">Déconnexion</a></li>
        </ul>
    </div>
    
    <div class="container">

            
        <?php User::print_users_rooms($data_base); ?>
            
        
    </div>

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