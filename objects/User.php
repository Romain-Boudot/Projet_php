<?php

    class User {


        public  $data_base;

        private $id;
        private $login;
        private $last_name;
        private $first_name;
        private $room_list = array();
        private $token_list = array();


        public function __construct() {

            $this->data_base = new Data_base;

        }


        public function token_gen($action, $id) {

            

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

?>