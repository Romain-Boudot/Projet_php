<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    
    header("Content-type: text/html");

    // check if session is up
    if (!isset($_SESSION['login'])) {
        echo '2';
        exit();
    }

    if(!isset($_POST) || !isset($_POST['id'])) {

        echo '1';
        exit();

    }

    $answer = $data_base->set_accepted($_POST['id']);


    /* $data_base = new Data_base();
    $db = $data_base->connexion();

    $db->exec("UPDATE assouser SET isvalidate = 1 WHERE userid = " . $_SESSION['id'] . " AND roomid = " . $_POST['id'] );

    $answer = $db->query(
        "SELECT name, login, isvalidate, id as rid
        FROM room r 
        JOIN users u on u . id = r . adminid 
        JOIN assouser a on u . id = a . userid AND r . id = a . roomid
        WHERE r . id = " . $_POST['id']);

    $answer = $answer->fetchAll(PDO::FETCH_ASSOC); */

    if($answer[0]['isvalidate'] != 1) {
    
        echo '1';
        exit();
    
    }

    $printer->show_room($answer);

    /* echo '<div id="id' . $_POST['id'] . '" class="row jumbotron jumbotron-fluid border border-secondary rounded p-0 clickable" onclick="location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room/index.php?id=' . $_POST['id'] . '\'">';        
    echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-secondary p-2 text-center">';
    echo $answer[0]['name'];
    echo '</div>';
    echo '<div class="col p-2">';
    echo $answer[0]['login'];
    echo '</div>';
    echo '<div class="col"></div>';
    echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
    echo 'testeuuuuuuu';
    echo '</div>';
    echo '</div>'; */

?>