<?php

    class User {


        public  $data_base;

        private $id;
        private $login;
        private $last_name;
        private $first_name;
        private $room_list = array(); // a virer
        private $token_list = array();


        public function __construct() {

            $this->data_base = new Data_base;

        }

      
        public function gen_token($action, $id) {

            $this->token_list[$action . $id] = new Token($action, $id);

            return $this->token_list[$action . $id]->get_token();

        }


        public function token_check($action, $id, $token) {

            $answer = $this->token_list[$action . $id].token_check($action, $id, $token);
            
            unset($this->token_list[$action . $id]);

            return $answer;

        }

      
        public function init($t_id, $t_login, $t_first_name, $t_last_name) {

            $this->id = $t_id;
            $this->last_name = $t_last_name;
            $this->first_name = $t_first_name;
            $this->login = $t_login;

        }

     
        public function token_gen_old($room_id) {

            if ($room_id == null) $rnd = bin2hex(random_bytes(1)); else $rnd = $room_id;
            $login  = $this->login;
            $id     = $this->id;
            $token  = bin2hex(random_bytes(10));
            
            $full_token = $rnd.'/'.$login.'/'.$id.'/';
            $full_token_converted = '';
            echo $full_token . $token . "\n";

            for ($i = 0; $i < strlen($full_token); $i++) {
            
                $temp = ord($full_token[$i]);
                if ($temp < 100) if ($temp < 10) $temp = '00' . $temp; else $temp = '0' . $temp;
                $full_token_converted = $full_token_converted . $temp;
            
            }

            echo $full_token_converted.$token;
            exit();

            $this->last_token = $full_token_converted;
            return $full_token_converted;

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

            if(sizeof($this->room_list) > 0) {
    
                echo '<div id="waiting_rooms" class="row text-center p-0">';

                foreach ($this->room_list as &$room) {

                    if($room->get_var('isvalidate') == 0) {

                        $room->print_validation_room();
                    }
                    
                }

                echo '</div><div id="admin_rooms" class="row text-center p-0">';

                foreach ($this->room_list as &$room) {

                    if($room->get_var('isadmin') == 1) {

                        $room->print_admin_room();
                    }

                }

                echo '</div><div id="basic_rooms" class="row text-center p-0">';

                foreach ($this->room_list as &$room) {

                    if($room->get_var('isadmin') == 0 && $room->get_var('isvalidate') == 1) {

                        $room->print_basic_room();
                    }

                }

                echo '</div>';
                    
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