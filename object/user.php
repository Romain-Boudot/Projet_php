<?php

    class User {


        public $id;
        public $login = 'lel';
        public $last_name;
        public $first_name;
        public $room_list = array();
        public $data_base;

        const   request     = 'mysql:host=localhost;dbname=projet_php;charset=utf8';
        const   login       = 'webclient';
        const   password    = 'webpassword';


        public function __construct($t_id, $t_login, $t_first_name, $t_last_name) {

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

            return $this->list_room[$room_id];

        }


        private function db_connexion() {

            try {
        
                return new PDO($this::request, $this::login, $this::password); 
            
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


        private function get_rooms() {


            $db = $this->db_connexion();


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


            for ($i = 0; $i < sizeof($statment); $i++) {

                $this->room_list[$statment[$i]['rid']] = new Room($this, $statment[$i]['rid'], $statment[$i]['author'], $statment[$i]['name'], $statment[$i]['isadmin'], $statment[$i]['isvalidate']);

            }

            //echo var_dump($this->room_list);

        }


        public function print_users_rooms() {


            $this->get_rooms();

            $db = $this->db_connexion();


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

    }

    class Room {


        private $user;
        private $id;
        private $author;
        private $name;
        private $isadmin;
        private $isvalidate;
        private $messages;
        private $invited_users;


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


        public function print_hello() {

            echo 'hello';

        }


        public function print_this_room() {

            if($this->isadmin == 1) {

                $this->get_admin_room($this->name, $this->author, "L'historique de messages n'est pas activer", $this->id);
            
            } else if($this->isvalidate == 0) {
            
                $this->get_validation_room($this->name, $this->author, $this->id);
            
            } else {
            
                $this->get_basic_room($this->name, $this->author, "L'historique de messages n'est pas activer", $this->id);
            
            }

        }


        private function get_basic_room($name, $author, $last_message, $id) {
    
            echo '<div id="id' . $id . '" class="row jumbotron jumbotron-fluid border border-secondary rounded p-0 clickable" onclick="location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room.php?id=' . $id . '\'">';        
            echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-secondary p-2 text-center">';
            echo $name;
            echo '</div>';
            echo '<div class="col p-2">';
            echo $author;
            echo '</div>';
            echo '<div class="col"></div>';
            echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
            echo $last_message;
            echo '</div>';
            echo '</div>';
    
        }
    

        private function get_admin_room($name, $author, $last_message, $id) {
    
            echo '<div id="id' . $id . '" class="row jumbotron jumbotron-fluid border border-primary rounded p-0 clickable" onclick="location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room.php?id=' . $id . '\'">';
            echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-primary p-2 text-center">';
            echo $name;
            echo '</div>';
            echo '<div class="col p-2">';
            echo $author;
            echo '</div>';
            echo '<div class="col"></div>';
            echo '<div class="w-100 bg-primary text-white p-4 text-truncate">';
            echo $last_message;
            echo '</div>';    
            echo '</div>';
        
        }
    

        private function get_validation_room($name, $author, $id) {
    
            echo '<div id="id' . $id . '" class="row jumbotron jumbotron-fluid border border-success rounded p-0">';
            echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-success p-2 text-center">';
            echo $name;
            echo '</div>';
            echo '<div class="col p-2">';
            echo $author;
            echo '</div>';
            echo '<div class="col"></div>';
            echo '<div class="w-100 bg-success text-white p-4 ">';
            echo '<button type="button" class="btn w-25 minw-100px btn-light mr-3 p-1" onclick="accept(' . $id . ')" role="button">accepter</a>';
            echo '<button type="button" class="btn w-25 minw-100px btn-danger p-1" onclick="refuse(' . $id . ')" role="button">refuser</a>';
            echo '</div>';
            echo '</div>';
        
        }

    }

?>