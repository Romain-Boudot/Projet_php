<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();


    // check if session is up

    login_test('[[-2]]');


    // we return some json array

    header("Content-type: text/javascript");

    
    if(!isset($_GET) || !isset($_GET['search'])) {
        echo '[[-1]]';
        exit();
    }


    $users = $data_base->search($_GET['search']);


    if(sizeof($users) > 25) 
        $size = 25;
    else
        $size = sizeof($users);


    echo "[";
    for($i = 0; $i < $size; $i++) {
        //if ($users[$i]['id'] == ($_SESSION['user']->get_var("id"))) continue;
        if($i > 0) echo ",";
        echo "[" . $users[$i]['id'] . ",\"" . $users[$i]['login'] . "\",\"" . $users[$i]['last_name'] . "\",\"" . $users[$i]['first_name'] . "\"]";
    }
    echo "]";

    // finish

?>