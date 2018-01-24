<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';

    // test of the login of the user
    login_test();

    if(isset($_GET) && isset($_GET['id'])) {

        try {
            $db = new PDO($request_db, $login_db, $password_db); 
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        $room_id = $_GET['id'];
        $id = $_SESSION['id'];

        $answer = $db->query('SELECT userid, roomid, isvalidate FROM assouser WHERE roomid =' . $room_id . ' AND userid = ' . $id);
        $answer = $answer->fetch();
        $is_validate = $answer['isvalidate'];

    }

    if($is_validate != 1) {
        echo 'vous n\'avez rien a faire ici!';
        exit();
    }

?>
<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <?php echo $bootstrap_css; ?>

</head>

<body>

    <nav class="navbar fixed-top navbar-dark bg-dark">

        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">

            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <a class='btn btn-outline-secondary ml-4' href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/pages/create_room.php" role="button">Créer une salle</a>
            <button type="button" class="btn btn-outline-secondary ml-2">

                Notifications<span class="badge badge-light ml-1">4</span>

            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>

        </div>

    </nav>

    <div id="message_container" class="mw-1200 mt-100px container-fluid">
        <div class="container-fluid w-100 bg-dark text-light">

            test message

        </div>
    </div>

    <div id="send_bar" class="p-2 w-100 bg-grey fixed-bottom">

            <div class="input-group mw-1200 container-fluid">
                <input id="message" type="text" class="form-control" placeholder="Message" maxlength="500">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="send_message()">Envoyer</button>
                </div>
            </div>

        
    </div>

    <script src="../javascript/message.js"></script>

</body>

</html>