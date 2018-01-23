<?php
    session_start();
    
    header("Content-type: text/html");

    // check if session is up
    if (!isset($_SESSION['login'])) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/pages/login.php");
        exit();
    }

    include '../include/var.php';

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
<html lang="fr">
<head>
    <title>room</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    COUCOU ... ca marche a peu pret 
</body>
</html>