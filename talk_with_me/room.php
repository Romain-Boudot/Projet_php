<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

    if(isset($_GET) && isset($_GET['id'])) {


        if ($_SESSION['user']->have_access($_GET['id']) == false) {

            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
            exit();

        }

    }


?>

<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../../main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

</head>

<body>

    <div id="current_room" hidden><?php echo $_GET['id']; ?></div>

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

    <div id="messages_container" style="scroll-behavior: smooth;" class="mw-1200 mt-100px container-fluid">
        
        <?php //$_SESSION['user']->get_this_room($_GET['id'])->print_messages(); ?>
        <script src="/socket.io/socket.io.js"></script>

        <script>

            var socket = io.connect('http://localhost:8080');

        </script>

    </div>


    <div id="scroll_bot" hidden>bla bla </div>

    <div id="send_bar" class="p-2 w-100 bg-grey fixed-bottom">

        <div class="input-group mw-1200 container-fluid">
            <input id="message" type="text" class="form-control" placeholder="Message" maxlength="1000">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="send_message()">Envoyer</button>
            </div>
        </div>

    </div>

    <script src="../../javascript/message.js"></script>
    
</body>

</html>