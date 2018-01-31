<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
    
    header("Content-type: text/html");

    // check if session is up
    login_test('login');


    if(!isset($_GET) || !isset($_GET['id'])) {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }

    $answer = $_SESSION['user']->get_this_room($_GET['id'])->accept($_GET['id']);

    header('location: http://' . $_SERVER['HTTP_HOST']);
    exit();

?>