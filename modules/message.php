<?php

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    header("Content-Type: text/html");
      
    $answer = $_SESSION['user']->get_this_room($_GET['id'])->get_new_messages();
    
    if ($answer != false) {

        
        foreach($answer as &$msg) {
            

            $_SESSION['user']->get_this_room($_GET['id'])->get_this_message($msg['id'])->print_this_message("js");
            
        }

    } else {

        echo "[-1,\"\"]";
    
    }

?>