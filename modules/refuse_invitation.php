<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
    
    header("Content-type: text/html");

    // check si il y a une session en cours, si non echo '2'
    login_test('login');

    if(!isset($_GET) || !isset($_GET['id'])) {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }

    $answer = $_SESSION['user']->get_this_room($_GET['id'])->refuse($_GET['id']);

    header('location: http://' . $_SERVER['HTTP_HOST']);
    exit();

?>