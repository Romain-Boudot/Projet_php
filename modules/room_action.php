<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
    
    header("Content-type: text/html");

    // check if session is up
    login_test('login');

    if(!isset($_GET) || !isset($_GET['id']) || !isset($_GET['action'])) {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }

    if ($_GET['action'] == 'delete' || $_GET['action'] == 'leave') {

        if (!isset($_GET['token'])) {
            
            header("location: ../talk_with_me/auth_check.php?id=".$_GET['id']."&action=".$_GET['action']);
            exit();
            
        } else if (is_null($_GET['token'])) {
            
            header("location: ../talk_with_me/auth_check.php?id=".$_GET['id']."&action=".$_GET['action']);
            exit();
            
        }
        
        if (!token_check($_GET['action'], $_GET['id'], $_GET['token'])) { 
            
            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
            exit();
            
        }
        
    }

    if ($_GET['action'] == 'accept') {  
        
        $answer = User::get_this_room($data_base, $_GET['id'])->accept($data_base);

    } else if ($_GET['action'] == 'refuse' || $_GET['action'] == 'leave') {

        $answer = User::get_this_room($data_base, $_GET['id'])->leave($data_base);

    } else if ($_GET['action'] == 'delete') {

        $answer = User::get_this_room($data_base, $_GET['id'])->delete_room($data_base);

    } else {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }


    header('location: http://' . $_SERVER['HTTP_HOST']);
    exit();

?>