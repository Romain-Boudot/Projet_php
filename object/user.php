<?php

    class Data_base {

        private $request  = 'mysql:host=localhost;dbname=projet_php;charset=utf8';
        private $client   = 'webclient';
        private $password = 'webpassword';


        public function db_connexion() {

            try {
        
                return new PDO($this->request, $this->client, $this->password); 
            
            } catch(Exception $e) {
            
                die('Erreur : ' . $e->getMessage());
            
            }

        }


        public function search($search) {


            $search = '%' . $search . '%';


            $db = $this->db_connexion();


            $statment = $db->prepare("SELECT id, login, last_name, first_name FROM users WHERE login LIKE :search");


            $statment->execute(array(":search" => $search));


            return $statment->fetchAll(PDO::FETCH_ASSOC);

        }


        public function password_check($login, $password) {


            $db = $this->db_connexion();


            $statment = $db->prepare("SELECT id, login, password, last_name, first_name, active FROM users where login = :userlogin");

            $statment->execute(array(":userlogin" => $login));

            $answer = $statment->fetch();

            if ( $answer['password'] != $password || $answer['active'] == 0) {

                return false;
            
            } else {
                
                return $answer;
                
            }

        }

    };

    class User {


        public  $data_base;

        private $id;
        private $login = 'lel';
        private $last_name;
        private $first_name;
        private $room_list = array();


        public function __construct() {

            $this->data_base = new Data_base;

        }


        public function init($t_id, $t_login, $t_first_name, $t_last_name) {

            $this->id = $t_id;
            $this->last_name = $t_last_name;
            $this->first_name = $t_first_name;
            $this->login = $t_login;

        }


        public function get_var($var) {


            if ($var == 'login') return $this->login;
            if ($var == 'id') return $this->id;
            if ($var == 'last_name') return $this->last_name;
            if ($var == 'firs_name') return $this->first_name;

        }


        public function get_this_room($room_id) {

            return $this->room_list[$room_id];

        }


        private function get_rooms() {


            $db = $this->data_base->db_connexion();


            $statment = $db->prepare(
                "SELECT roomid as rid, isadmin, isvalidate, (
                    SELECT login
                    FROM users u
                    WHERE id = (
                        SELECT adminid
                        FROM room r
                        WHERE id = rid
                    )
                ) as author, (
                    SELECT name
                    FROM room
                    WHERE id = rid
                ) as name
                FROM assouser a
                WHERE userid = :userid");
            
            $statment->execute(array(":userid" => $this->id));

            $statment = $statment->fetchAll(PDO::FETCH_ASSOC);


            $this->room_list = array();


            foreach ($statment as &$state) {

                $this->room_list[$state['rid']] = new Room($this, $state['rid'], $state['author'], $state['name'], $state['isadmin'], $state['isvalidate']);

            }

            //echo var_dump($this->room_list);

        }


        public function print_users_rooms() {


            $this->get_rooms();
            

            $db = $this->data_base->db_connexion();


            if(sizeof($this->room_list) > 0) {
    
                foreach($this->room_list as &$room) {
                
                    $room->print_this_room();

                }
                    
            } else {
                    
                echo "<div class='jumbotron jumbotron-fluid border border-secondary rounded p-4'>";
                echo "<p class='d-inline'>Vous n'avez accès à aucune salle, mais vous pouvez en créer une !</p>";
                echo "</div>";
                
            }

        }


        public function have_access($room_id) {

            if (isset($this->room_list[$room_id])) {

                if ($this->room_list[$room_id]->get_var('isvalidate') == 1)
                    return true;

            }

            return false;

        }


        public function create_room($room_name, $invited_users) {
        

            $db = $this->data_base->db_connexion();


            $statment = $db->prepare("INSERT INTO room (name, adminid) VALUES (:room_name, :sessionid)");
            
            $statment->execute(array(":room_name" => $room_name, ":sessionid" => $this->id));
            

            // we take the last id inserted
            
            $last_id = $db->lastInsertId();
            
            
            // we add the admin to his room
            
            $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:last_id, :sessionid, 1 , 1)");
        
            $statment->execute(array(":last_id" => $last_id, ":sessionid" => $this->id));
        
            
            // creation de la room

            $this->room_list[$last_id] = new Room($this, $last_id, $this->login, $room_name, 1, 1);


            // on ajoute les utilisateur à la room

            $this->room_list[$last_id]->add_user_room($invited_users);
        
        }

    };

    class Room {


        private $user;
        private $id;
        private $author;
        private $name;
        private $isadmin;
        private $isvalidate;
        private $messages = array();
        private $invited_users;
        private $last_message_id = 0;


        public function __construct($t_user, $t_id, $t_author, $t_name, $t_isadmin, $t_isvalidate) {


            $this->user = $t_user;
            $this->id = $t_id;
            $this->author = $t_author;
            $this->name = $t_name;
            $this->isadmin = $t_isadmin;
            $this->isvalidate = $t_isvalidate;

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

                $db = $this->user->data_base->db_connexion();


                $statment = $db->prepare("UPDATE assouser SET isvalidate = 1 WHERE userid = :userid AND roomid = :roomid ");


                $statment->execute(array(":userid" => $this->user->get_var('id'), ":roomid" => $this->id));


                $this->isvalidate = 1;

            } else {

                header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/unknown.php');
                exit();

            }

        }


        public function leave() {

            


            $db = $this->user->data_base->db_connexion();


            $statment = $db->prepare("DELETE FROM assouser WHERE userid = :userid AND roomid = :roomid ");


            $statment->execute(array(":userid" => $this->user->get_var('id'), ":roomid" => $this->id));


        }


        public function delete_room() {

            $db = $this->user->data_base->db_connexion();

            $statment = $db->prepare("DELETE FROM message WHERE roomid = :roomid");

            $statment->execute(array(":roomid" => $this->id));

            $statment = $db->prepare("DELETE FROM assouser WHERE roomid = :roomid");

            $statment->execute(array(":roomid"=> $this->id));

            $statment = $db->prepare("DELETE FROM room WHERE id = :id");

            $statment->execute(array(":id"=> $this->id));

        }
        
        
        public function add_user_room($invited_users) {
        
        
            $db = $this->user->data_base->db_connexion();
            
        
            foreach ($invited_users as &$user) {


                $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:room_id, :invited, 0 , 0)");

                $statment->execute(array(":room_id" => $this->id, ":invited" => $user));


                $this->invited_users[$user] = $user;
            
            }
        
        }


        // messages de la room

        public function get_new_messages() {


            $db = $this->user->data_base->db_connexion();

            $statment = $db->prepare("SELECT id, roomid, (
                SELECT login FROM users WHERE id = m . authorid
            ) as author, content, date FROM message m WHERE roomid = :roomid AND id > :lastMsgId ORDER BY date asc");

            $statment->execute(array(":roomid" => $this->id, ":lastMsgId" => $this->last_message_id));

            $statment = $statment->fetchAll(PDO::FETCH_ASSOC);

            if (sizeof($statment) > 0) {


                foreach($statment as &$message) {
                    
                    $this->messages[$message['id']] = new Message($this, $message['id'], $message['author'], $message['content'], $message['date']);
                    if ($message['id'] > $this->last_message_id) $this->last_message_id = $message['id'];
                    
                }

                return $statment;
                
            } else {

                return false;

            }

        }


        private function get_old_messages() {

            
            $db = $this->user->data_base->db_connexion();


            $statment = $db->prepare("SELECT id, roomid, (
                SELECT login FROM users WHERE id = m . authorid
            ) as author, content, date FROM message m WHERE roomid = :roomid ORDER BY date asc");

            $statment->execute(array(":roomid" => $this->id));

            $statment = $statment->fetchAll(PDO::FETCH_ASSOC);


            $this->messages = array();

            foreach($statment as &$message) {

                $this->messages[$message['id']] = new Message($this, $message['id'], $message['author'], $message['content'], $message['date']);
                if ($message['id'] > $this->last_message_id) $this->last_message_id = $message['id'];

            }

        }

        
        public function send_message($content) {


            $date = date("o-m-d H:i:s", time());

            $db = $this->user->data_base->db_connexion();

            $statment = $db->prepare("INSERT INTO message (roomid, authorid, content, date) VALUES (:roomid, :authorid, :content, :date)");

            $statment->execute(array(
                ":roomid" => $this->id,
                ":authorid" => $this->user->get_var('id'),
                ":content" => $content,
                ":date" => $date));

            $last_id = $db->lastInsertId();

            $this->messages[$last_id] = new Message($this, $last_id, $this->user->get_var('id'), $content, $date);

        }


        public function get_this_message($msg_id) {

            return $this->messages[$msg_id];

        }


        public function print_messages() {

            $this->get_old_messages();

            foreach ($this->messages as &$message) {

                $message->print_this_message();

            }

        }


        // affichage de la room

        public function print_this_room() {

            if($this->isadmin == 1) {

                $this->print_admin_room($this->name, $this->author, "L'historique de messages n'est pas activer", $this->id);
            
            } else if($this->isvalidate == 0) {
            
                $this->print_validation_room($this->name, $this->author, $this->id);
            
            } else {
            
                $this->print_basic_room($this->name, $this->author, "L'historique de messages n'est pas activer", $this->id);
            
            }

        }


        private function print_basic_room() {
    
            echo '<div id="id' . $this->id . '" class="row jumbotron jumbotron-fluid border border-secondary rounded p-0 clickable" onclick="';
            echo 'location.href=\'http://yuumii.ovh:8080/' . $this->id . '/' . $this->user->get_var('login') . '/' . $this->user->get_var('id') . '/-1\'">';
            echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-secondary p-2 text-center">';
            echo $this->name;
            echo '</div>';
            echo '<div class="col p-2">';
            echo $this->author;
            echo '</div>';
            echo '<div class="col">';
            echo '<a href="../modules/room_action.php?id=' . $this->id . '&action=leave" role="button" class="close" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
            echo 'L\'historique des messages est desactiver'; // last message
            echo '</div>';
            echo '</div>';
    
        }
    

        private function print_admin_room($name, $author, $last_message, $id) {
    
            echo '<div id="id' . $this->id . '" class="row jumbotron jumbotron-fluid border border-primary rounded p-0 clickable" onclick="';
            echo 'location.href=\'http://yuumii.ovh:8080/' . $this->id . '/' . $this->user->get_var('login') . '/' . $this->user->get_var('id') . '/-1\'">';
            echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-primary p-2 text-center">';
            echo $this->name;
            echo '</div>';
            echo '<div class="col p-2">';
            echo $this->author;
            echo '</div>';
            echo '<div class="col">';
            echo '<a href="../modules/room_action.php?id=' . $this->id . '&action=delete" role="button" class="close" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</a>';
            echo '</div>';
            echo '<div class="w-100 bg-primary text-white p-4 text-truncate">';
            echo 'L\'historique des messages est desactiver'; // last message
            echo '</div>';    
            echo '</div>';
        
        }
    

        private function print_validation_room($name, $author, $id) {
    
            echo '<div id="id' . $this->id . '" class="row jumbotron jumbotron-fluid border border-success rounded p-0">';
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


    class Message {

        private $id;
        private $room_id;
        private $author;
        private $content;
        private $date;


        public function __construct($t_room, $t_id, $t_author, $t_content, $t_date) {

            $this->id       = $t_id;
            $this->room_id  = $t_room;
            $this->author   = $t_author;
            $this->content  = $t_content;
            $this->date     = $t_date;

        }


        public function print_this_message() {

            echo '<div class="container-fluid bg-light p-3 rounded">';
            echo '<span class="font-weight-light pr-2 text-little">' . $this->date . '</span>';
            echo '<span class="text-danger border border-bottom-0 border-top-0 border-left-0 border-secondary pr-2 mr-2">' . $this->author . '</span>';
            echo $this->content;
            echo '</div>';
            echo '<br>';

        }

    };

?>