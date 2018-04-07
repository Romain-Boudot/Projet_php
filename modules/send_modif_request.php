<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
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

    function search_delete_user($answer, $invited_users) {

        $deleteusers = [];

        foreach($answer as &$user) {

            if (!in_array($user['userid'], $invited_users)) {

                $deleteusers[sizeof($deleteusers)] = $user['userid'];

            }

        }

        return $deleteusers;

    }

    function search_invite_users($answer, $invited_users) {

        $inviteusers = [];

        foreach($invited_users as &$user) {

            if (!in_array($user, $answer)) {

                $inviteusers[sizeof($inviteusers)] = $user;

            }

        }

        return $inviteusers;

    }
    
    if(isset($_POST) && isset($_POST['name'])) {
        

        $invited_users = [];
        $room_name = $_POST['name'];

        $room_name = str_replace("<", "&lt;", $room_name);
        $room_name = str_replace(">", "&gt;", $room_name);


        if(isset($_POST['user'])) {

            $user = explode(';', $_POST['user']);
            
            //check duplicates and potential hacker to prevente invitation of the current user in user_invited_list
            for($i = 0; $i < sizeof($user); $i++) {

                if($user[$i] == $_SESSION['user']['id']) continue;
                if(check_duplicate($user[$i], $invited_users) == true) continue;

                $invited_users[sizeof($invited_users)] = $user[$i];

            }

        }

        $db = Data_base::db_connexion();

        $statment = $db->prepare("SELECT userid FROM assouser WHERE roomid = :id");

        $statment->execute(array(
            ":id" => $_POST['id']
        ));

        $answer = $statment->fetchAll(PDO::FETCH_ASSOC);

        $deleteusers = search_delete_user($answer, $invited_users);

        $inviteusers = search_invite_users($answer, $invited_users);

        // we add a new room in the database

        User::modif_room($_POST['id'], $room_name, $deleteusers, $inviteusers);

        echo "[0]"; // the room is created, we informe the user
        exit(); // stop the script

    }
    
    echo '[1]'; // the room is not created, we informe the user

?>