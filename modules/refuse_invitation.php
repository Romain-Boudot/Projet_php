<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    
    header("Content-type: text/html");

    // check si il y a une session en cours, si non echo '2'
    login_test('2');

    if(!isset($_POST) || !isset($_POST['id'])) {

        echo '1';
        exit();

    }

    $db = data_base_connexion();

    $db->exec("DELETE FROM assouser WHERE userid = " . $_SESSION['id'] . " AND roomid = " . $_POST['id'] );

?>