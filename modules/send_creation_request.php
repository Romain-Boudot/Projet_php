<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();
    
    header("Content-type: text/javascript");

    // check if session is up
    login_test('[2]');
    
    function check_duplicate($id, $invited_users) {
        
        for($j = 0; $j < sizeof($invited_users); $j++) {
            if($id == $invited_users[$j]) return true;
        }
        
        return false;
        
    }
    
    if(isset($_POST) && isset($_POST['name'])) {
        

        $invited_users = [];
        $room_name = $_POST['name'];


        if(isset($_POST['user'])) {

            $user = explode(';', $_POST['user']);
            
            //check duplicates and potential hacker to prevente invitation of the current user in user_invited_list
            for($i = 0; $i < sizeof($user); $i++) {

                if($user[$i] == $_SESSION['user']['id']) continue;
                if(check_duplicate($user[$i], $invited_users) == true) continue;

                $invited_users[sizeof($invited_users)] = $user[$i];

            }

        }

        // we add a new room in the database

        User::create_room($data_base, $room_name, $invited_users);


        echo "[0]"; // the room is created, we informe the user
        exit(); // stop the script
    }
    
    echo '[1]'; // the room is not created, we informe the user
?>