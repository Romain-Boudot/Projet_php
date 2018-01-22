<?php
    session_start();
    
    header("Content-type: text/javascript");

    // check if session is up
    if (!isset($_SESSION['login'])) {
        echo "[2]";
        exit();
    }

    include '../include/var.php';
    
    if(isset($_POST) && isset($_POST['id'])) {

        // test of the owner of the room
        $owner = $db->query('SELECT adminid FROM room WHERE id = ' . $_POST['id']);
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