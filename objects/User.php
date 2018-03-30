<?php

    class User {


        private $id;
        private $login;
        private $last_name;
        private $first_name;
        private $room_list = array(); // a virer

      
        public function __construct($id) {

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

            $db = Data_base::db_connexion();

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
                WHERE userid = :userid
                AND roomid = :roomid");

            $statment->execute(array(":userid" => $_SESSION['user']['id'], ":roomid" => $room_id));

            $state = $statment->fetch();

            return new Room($state['rid'], $state['author'], $state['name'], $state['isadmin'], $state['isvalidate']);

        }


        private function get_rooms() {


            $db = Data_base::db_connexion();


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
            
            $statment->execute(array(":userid" => $_SESSION['user']['id']));

            $statment = $statment->fetchAll(PDO::FETCH_ASSOC);


            $room_list = array();


            foreach ($statment as &$state) {

                $room_list[$state['rid']] = new Room($state['rid'], $state['author'], $state['name'], $state['isadmin'], $state['isvalidate']);

            }

            return $room_list;

        }


        public function print_users_rooms() {


            $room_list = User::get_rooms();

            if(sizeof($room_list) > 0) {
    
                echo '<div id="waiting_rooms" class="row text-center p-0">';

                foreach ($room_list as &$room) {

                    if($room->get_var('isvalidate') == 0) {

                        $room->print_validation_room();
                    }
                    
                }

                echo '</div><div id="admin_rooms" class="row text-center p-0">';

                foreach ($room_list as &$room) {

                    if($room->get_var('isadmin') == 1) {

                        $room->print_admin_room();
                    }

                }

                echo '</div><div id="basic_rooms" class="row text-center p-0">';

                foreach ($room_list as &$room) {

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


        public function create_room($room_name, $invited_users) {
        

            $db = Data_base::db_connexion();


            $statment = $db->prepare("INSERT INTO room (name, adminid) VALUES (:room_name, :sessionid)");
            
            $statment->execute(array(":room_name" => $room_name, ":sessionid" => $_SESSION['user']['id']));
            

            // we take the last id inserted
            
            $last_id = $db->lastInsertId();
            
            
            // we add the admin to his room
            
            $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:last_id, :sessionid, 1 , 1)");
        
            $statment->execute(array(":last_id" => $last_id, ":sessionid" => $_SESSION['user']['id']));


            // on ajoute les utilisateur à la room

            Room::add_user_room($invited_users, $last_id);
        
        }

    };

?>