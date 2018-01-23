<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    
    header("Content-type: text/javascript");

    // check if session is up
    if (!isset($_SESSION['login'])) {
        echo "[2]";
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
        
        // test of the owner of the room
        $owner = $db->query('SELECT adminid FROM room WHERE id = ' . $room_id);
        $owner = $owner->fetch();
        $owner = $owner['adminid'];

        if($owner != $_SESSION['id']) {
            echo '[1]'; // the room is not deleted, we informe the user
            exit();
        }

        echo "[0]"; // the room is deleted, we informe the user
        exit(); // stop the script
    }
    
    echo '[1]'; // the room is not deleted, we informe the user

?>