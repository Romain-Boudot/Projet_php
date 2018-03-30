<?php

    /* // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    header("Content-Type: text/javascript");
      
    $answer = User::get_this_room($data_base, $_GET['id'])->get_new_messages($data_base);
    
    if ($answer != false) {

        
        foreach($answer as &$msg) {
            

            $_SESSION['user']->get_this_room($_GET['id'])->get_this_message($msg['id'])->print_this_message("js");
            
        }

    } else {

        echo "[-1,\"\"]";
    
    } */

?>

<?php

    /////////////////////////// obsolete

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
        
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');

    //$_SESSION['room' . $_GET['id']]['last_id'];

    while (1){

        echo "event: message\n";
        echo "data: ";

        $answer = User::get_this_room($data_base, $_GET['id'])->get_new_messages($data_base);

    
        if ($answer != false) {

            
            foreach($answer as &$msg) {
                

                $msg->print_this_message("js");
                
            }

        } else {

            echo "[-1,\"\"]";
        
        }

        echo "\n\n";

        ob_flush();
        flush();

        sleep(1);

    }    

?>
