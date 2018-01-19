<?php
    //demarrage ou reprise de session ! super important a mettre toujours en premier !
    session_start();

    // test de connexion au site
    if (!isset($_SESSION['login'])) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/pages/login.php");
        exit();
    }

    // les variables !
    include $_SERVER['DOCUMENT_ROOT'] . '/include/var.php';

    //on recupe les room
    try {
        $db = new PDO($request_db, $login_db, $password_db); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

?>