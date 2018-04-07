<?php

class Room {


    private $id;
    private $author;
    private $name;
    private $isadmin;
    private $isvalidate;
    private $invited_users;
    private $last_message_id = 0;


    public function __construct($t_id, $t_author, $t_name, $t_isadmin, $t_isvalidate) {


        $this->id = $t_id;
        $this->author = $t_author;
        $this->name = $t_name;
        $this->isadmin = $t_isadmin;
        $this->isvalidate = $t_isvalidate;

    }

    public function have_access($room_id) {

        if ($this->isvalidate == 1) return true;
        else return false;
        
    }


    public function get_var($var) {


        if ($var == 'user') return $this->user;
        if ($var == 'id') return $this->id;
        if ($var == 'name') return $this->name;
        if ($var == 'isadmin') return $this->isadmin;
        if ($var == 'isvalidate') return $this->isvalidate;

    }


    // parametrage de la room

    public function accept() {

        if ($this->isvalidate == 0) {

            $db = Data_base::db_connexion();


            $statment = $db->prepare("UPDATE assouser SET isvalidate = 1 WHERE userid = :userid AND roomid = :roomid ");


            $statment->execute(array(":userid" => $_SESSION['user']['id'], ":roomid" => $this->id));


            $this->isvalidate = 1;

        } else {

            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
            exit();

        }

    }


    public function leave() {

        // manque une verif admin

        $db = Data_base::db_connexion();


        $statment = $db->prepare("DELETE FROM assouser WHERE userid = :userid AND roomid = :roomid ");


        $statment->execute(array(":userid" => $_SESSION['user']['id'], ":roomid" => $this->id));


    }


    public function delete_room() {

        if ($this->isadmin == 0) {
            
            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
            exit();

        }

        $db = Data_base::db_connexion();

        $statment = $db->prepare("DELETE FROM message WHERE roomid = :roomid");

        $statment->execute(array(":roomid" => $this->id));

        $statment = $db->prepare("DELETE FROM assouser WHERE roomid = :roomid");

        $statment->execute(array(":roomid"=> $this->id));

        $statment = $db->prepare("DELETE FROM room WHERE id = :id");

        $statment->execute(array(":id"=> $this->id));

    }
    
    
    public function add_user_room($invited_users, $rid) {
    
    
        $db = Data_base::db_connexion();
        
    
        foreach ($invited_users as &$user) {


            $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:room_id, :invited, 0 , 0)");

            $statment->execute(array(":room_id" => $rid, ":invited" => $user));
        
        }
    
    }


    public function delete_user_room($deleteusers, $rid) {
    
    
        $db = Data_base::db_connexion();
    
        foreach ($deleteusers as &$user) {

            if ($user == $_SESSION['user']['id']) continue;

            $statment = $db->prepare("DELETE FROM assouser WHERE roomid = :roomid AND userid = :userid");

            $statment->execute(array(":roomid" => $rid, ":userid" => $user));
        
        }
    
    }


    // messages de la room

    public function get_new_messages() {


        $db = Data_base::db_connexion();

        $statment = $db->prepare("SELECT id, roomid, authorid, (
            SELECT login FROM users WHERE id = m . authorid
        ) as author, content, date FROM message m WHERE roomid = :roomid AND id > :lastMsgId ORDER BY date asc");

        $statment->execute(array(":roomid" => $this->id, ":lastMsgId" => $_SESSION['room' . $this->id]));

        $statment = $statment->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($statment) > 0) {


            foreach($statment as &$message) {
                
                $messages[$message['id']] = new Message($this, $message['id'], $message['author'], $message['content'], $message['date'], $message['authorid']);

                if ($message['id'] > $_SESSION['room' . $this->id]) $_SESSION['room' . $this->id] = $message['id'];
                
            }

            return $messages;
            
        } else {

            return false;

        }

    }


    private function get_old_messages() {
        
        $db = Data_base::db_connexion();


        $statment = $db->prepare("SELECT id, roomid, authorid, (
            SELECT login FROM users WHERE id = m . authorid
        ) as author, content, date FROM message m WHERE roomid = :roomid ORDER BY date asc");

        $statment->execute(array(":roomid" => $this->id));

        $statment = $statment->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();

        $_SESSION['room' . $this->id] = 0;

        foreach($statment as &$message) {

            $messages[$message['id']] = new Message($this, $message['id'], $message['author'], $message['content'], $message['date'], $message['authorid']);
            
            if ($message['id'] > $_SESSION['room' . $this->id]) $_SESSION['room' . $this->id] = $message['id'];

        }

        return $messages;

    }

    
    public function send_message($content) {


        $date = date("o-m-d H:i:s", time());

        $db = Data_base::db_connexion();

        $statment = $db->prepare("INSERT INTO message (roomid, authorid, content, date) VALUES (:roomid, :authorid, :content, :date)");

        $statment->execute(array(
            ":roomid" => $this->id,
            ":authorid" => $_SESSION['user']['id'],
            ":content" => $content,
            ":date" => $date));

    }

    // obsolete
    /* public function get_this_message($msg_id) {

        return $this->messages[$msg_id];

    } */


    public function print_messages() {

        $messages = $this->get_old_messages();

        foreach ($messages as &$message) {

            $message->print_this_message("php");

        }

    }


    public function print_basic_room() {

        echo '<div id="id' . $this->id . '" class="shadow-2 col row jumbotron jumbotron-fluid border border-secondary rounded m-1 p-0 clickable flex-div" onclick="';
        echo 'location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room.php?id=' . $this->id . '\'">';
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-secondary p-2 text-center">';
        echo $this->name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $this->author;
        echo '</div>';
        echo '<div class="col">';
        echo '<a href="../modules/room_action.php?id=' . $this->id . '&action=leave" role="button" class="close mt-8px" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</a>';
        echo '</div>';
        echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
        echo 'L\'historique des messages est désactivé'; // last message
        echo '</div>';
        echo '</div>';

    }

    public function print_admin_room() {

        echo '<div id="id' . $this->id . '" class="shadow-2 col row jumbotron jumbotron-fluid border border-primary rounded p-0 m-1 clickable flex-div" onclick="';
        echo 'location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room.php?id=' . $this->id . '\'">';
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-primary p-2 text-center">';
        echo $this->name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $this->author;
        echo '</div>';
        echo '<div class="col">';
        echo '<a href="../modules/room_action.php?id=' . $this->id . '&action=delete" role="button" class="close mt-8px" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</a>';
        echo '</div>';
        echo '<div class="w-100 bg-primary text-white p-4 text-truncate">';
        echo 'L\'historique des messages est désactivé'; // last message
        echo '</div>';    
        echo '</div>';
    
    }


    public function print_validation_room() {

        echo '<div id="id' . $this->id . '" class="shadow-2 col row jumbotron jumbotron-fluid border border-success rounded p-0 m-1 flex-div">';
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-success p-2 text-center">';
        echo $this->name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $this->author;
        echo '</div>';
        echo '<div class="col"></div>';
        echo '<div class="w-100 bg-success text-white p-4 ">';
        echo '<a role="button" class="btn w-25 minw-100px btn-light mr-3 p-1" href="http://' . $_SERVER['HTTP_HOST'] . '/modules/room_action.php?action=accept&id=' . $this->id . '" role="button">accepter</a>';
        echo '<a role="button" class="btn w-25 minw-100px btn-danger p-1" href="http://' . $_SERVER['HTTP_HOST'] . '/modules/room_action.php?action=refuse&id=' . $this->id . '" role="button">refuser</a>';
        echo '</div>';
        echo '</div>';
    
    }


};

?>