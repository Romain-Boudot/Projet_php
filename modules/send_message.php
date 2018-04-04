<?php

    //////////////////// obsolete

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();

    header("Content-type: text/javascript");


    // check if session is up
    login_test('2');


    if(isset($_POST) && isset($_POST['roomid']) && isset($_POST['content'])) {


        User::get_this_room($_POST['roomid'])->send_message($_POST['content']);


        echo "0"; // the message is sent
        exit(); // stop the script

    }


    echo '1';

?>