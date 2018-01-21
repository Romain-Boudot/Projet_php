<?php
    session_start();
    
    header("Content-type: text/javascript");

    // check if session is up
    if (!isset($_SESSION['login'])) {
        echo "[2]";
        exit();
    }

    include '../include/var.php';
    
    function check_duplicate($id) {
        
        for($j = 0; $j < sizeof($invited_users); $j++) {
            if($id == $invited_users[$j]) return true;
        }
        
        return false;
        
    }
    
    if(isset($_POST) && isset($_POST['name'])) {
        
        $invited_users;
        $room_name = $_POST['name'];
        
        try {
            $db = new PDO($request_db, $login_db, $password_db); 
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        if(isset($_POST['user'])) {

            $user = explode(';', $_POST['user']);
            
            //check duplicates and potential hacker to prevente invitation of the current user in user_invited_list
            for($i = 0; $i < sizeof($user); $i++) {

                if($user[$i] == $_SESSION['id']) continue;
                if(check_duplicate($user[$i]) == true) continue;

                $invited_users[sizeof($invited_users)] = $user[$i];

            }

        }

        // we add a new room in the database

        $answer = $db->exec('INSERT INTO room (name, adminid) VALUES (\'' . $room_name . '\', ' . $_SESSION["id"] . ')');
        // we take the last id inserted
        $last_id = $db->lastInsertId();
        // we add the user to his room
        $answer = $db->exec('INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (' . $last_id . ', ' . $_SESSION["id"] . ', 1 , 1)');

        // we add the others user
        for($i = 0; $i < sizeof($invited_users); $i++) {
            $answer = $db->exec('INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (' . $last_id . ', ' . $invited_users[$i] . ', 0 , 0)');
        }


        echo "[0]"; // the room is created, we informe the user
        exit(); // stop the script
    }
    
    echo '[1]'; // the room is not created, we informe the user
?>