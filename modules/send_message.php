<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    header("Content-type: text/javascript");


    // check if session is up
    login_test('[2]');


    if(isset($_POST) && isset($_POST['room_id']) && isset($_POST['content'])) {


        $_SESSION['user']->get_room($_POST['room_id'])->send_message($_POST['content']);


        echo "[0]"; // the message is sent
        exit(); // stop the script
    }

?>