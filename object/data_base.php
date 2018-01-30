<?php
    class Data_base {


        const   request     = 'mysql:host=localhost;dbname=projet_php;charset=utf8';
        const   login       = 'webclient';
        const   password    = 'webpassword';


        private function connexion() {

            try {
        
                return new PDO($this::request, $this::login, $this::password); 
            
            } catch(Exception $e) {
            
                die('Erreur : ' . $e->getMessage());
            
            }

        }


        public function get_room($userid) {


            $db = $this->connexion();


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
            
            $statment->execute(array(":userid" => $userid));

            return $statment->fetchAll(PDO::FETCH_ASSOC);

        }


        public function password_check($login, $password) {


            $db = $this->connexion();


            $statment = $db->prepare("SELECT id, login, password, last_name, first_name, active FROM users where login = :userlogin");

            $statment->execute(array(":userlogin" => $login));

            $answer = $statment->fetch();

            if ( $answer['password'] != $password || $answer['active'] == 0) {

                return false;
            
            } else {
                
                return $answer;
                
            }

        }


        public function search($search) {


            $search = '%' . $search . '%';


            $db = $this->connexion();


            $statment = $db->prepare("SELECT id, login, last_name, first_name FROM users WHERE login LIKE :search");


            $statment->execute(array(":search" => $search));


            return $statment->fetchAll(PDO::FETCH_ASSOC);

        }
        

        public function add_user_room($room_id, $invited_users) {
        
        
            $db = $this->connexion();
            
        
            for($i = 0; $i < sizeof($invited_users); $i++) {
        
                $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:room_id, :invited, 0 , 0)");
                $statment->execute(array(":room_id" => $room_id, ":invited" => $invited_users[$i]));
            
            }
        
        }


        public function create_room($room_name, $invited_users) {
        

            $db = $this->connexion();


            $statment = $db->prepare("INSERT INTO room (name, adminid) VALUES (:room_name, :sessionid)");
            
            $statment->execute(array(":room_name" => $room_name, ":sessionid" => $_SESSION['id']));
            
            // we take the last id inserted
            
            $last_id = $db->lastInsertId();
            
            
            // we add the user to his room
            
            $statment = $db->prepare("INSERT INTO assouser (roomid, userid, isadmin, isvalidate) VALUES (:last_id, :sessionid, 1 , 1)");
        
            $statment->execute(array(":last_id" => $last_id, ":sessionid" => $_SESSION['id']));
        
            
            $this->add_user_room($last_id, $invited_users);
        
        }


        public function enter_access($room_id, $user_id) {


            $db = $this->connexion();
            
            
            $statment = $db->prepare('SELECT isvalidate FROM assouser WHERE roomid = :roomid AND userid = :userid');
            
            $statment->execute(array(":roomid" => $room_id, ":userid" => $user_id));
            
            $statment = $statment->fetch();
            

            if ($statment['isvalidate'] == 1) 
            
                return true;
            
            else 
            
                return false;

        }

    }

?>