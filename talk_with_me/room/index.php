<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';

    // test of the login of the user
    login_test('login');

    if(isset($_GET) && isset($_GET['id'])) {
        
        
        $room_id = $_GET['id'];
        $id = $_SESSION['id'];

        if ($data_base->enter_access($_GET['id'], $_SESSION['id']) == false) {

            echo 'vous n\'avez rien a faire ici!';
            exit();

        }

    }

    // ME SUIS ARRETER LA

    $db = data_base_connexion();

    $old_message = $db->query(
        'SELECT content, date, login
        FROM message m
        JOIN users u on u . id = m . authorid
        WHERE roomid = ' . $room_id);
    
    $old_message = $old_message->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../../main.css">
    <?php echo $bootstrap_css; ?>

</head>

<body>

    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <a class='btn btn-outline-secondary ml-4' href="<?php echo $location_create; ?>" role="button">Créer une salle</a>
            <button type="button" class="btn btn-outline-secondary ml-2">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>

    <div id="message_container" class="mw-1200 mt-100px container-fluid">
        
        <?php

            for ($i = 0; $i < sizeof($old_message); $i++) {

                show_message($old_message[$i]['login'], $old_message[$i]['content'], $old_message[$i]['date']);

            }

        ?>

    </div>

    <div id="send_bar" class="p-2 w-100 bg-grey fixed-bottom">

        <div class="input-group mw-1200 container-fluid">
            <input id="message" type="text" class="form-control" placeholder="Message" maxlength="500">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="send_message()">Envoyer</button>
            </div>
        </div>

    </div>

    <script src="../../javascript/message.js"></script>

</body>

</html>