<?php

///////////////////// obsolete

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();
    
    header("Content-type: text/html");

    // check if session is up
    login_test('login');


    if(!isset($_GET) || !isset($_GET['messageid']) || !isset($_GET['action']) || !isset($_GET['roomid'])) {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }

    if ($_GET['action'] == 'delete') {
        
        $answer = $_SESSION['user']->get_this_room($_GET['roomid'])->get_this_message($_GET['messageid'])->delete();

    } else {

        header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
        exit();

    }


    header('location: http://' . $_SERVER['HTTP_HOST']);
    exit();

?>