<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // check si une session est en cours, si non redirige vers #login
    login_test('login');

    //$data = $_SESSION['user']->get_room();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
      
</head>

<body>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['user']->get_var("login"); ?></span>
            <a class='btn btn-outline-secondary ml-4' href="<?php echo $location_create; ?>" role="button">Créer une salle</a>
            <button type="button" class="btn btn-outline-secondary ml-2">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>
    
    <div id="room_container" class="container">

        <?php $_SESSION['user']->print_users_rooms(); ?>

    </div>

    <script src="javascript/validation_room.js"></script>

</body>

</html>