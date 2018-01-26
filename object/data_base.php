<?php

    /*

        $data_base = new Data_base();
        $db = $data_base->connexion();

    */

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


            $statment = $db->prepare("SELECT id, password, last_name, first_name, active FROM users where login = :userlogin");

            $statment->execute(array(":userlogin" => $login));

            $answer = $statment->fetch();

            if ( $answer['password'] != $password || $answer['active'] == 0) {

                return false;
            
            } else {
                
                return $answer;
                
            }



        }

    }

?>