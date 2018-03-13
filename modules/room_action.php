<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
    
    header("Content-type: text/html");

    // check if session is up
    login_test('login');

    if (is_null($_GET['token']) || !isset($_GET['action'])) {

        header("location: ../talk_with_me/auth_check.php?id=".$_GET['id']."%26action=".$_GET['action']." vers captcha avec action et id en get");

    }

    if (!$_SESSION['user']->token_check($_GET['action'], $_GET['id'], $_GET['token'])) { 
        
        header("location: ../talk_with_me/error/unknown.php"); 

    }

    if(!isset($_GET) || !isset($_GET['id']) || !isset($_GET['action'])) {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
        exit();

    }

    if ($_GET['action'] == 'accept') {  
        
        $answer = $_SESSION['user']->get_this_room($_GET['id'])->accept($_GET['id']);

    } else if ($_GET['action'] == 'refuse' || $_GET['action'] == 'leave') {

        $answer = $_SESSION['user']->get_this_room($_GET['id'])->leave($_GET['id']);

    } else if ($_GET['action'] == 'delete') {

        $answer = $_SESSION['user']->get_this_room($_GET['id'])->delete_room();

    } else {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }


    header('location: http://' . $_SERVER['HTTP_HOST']);
    exit();

?>