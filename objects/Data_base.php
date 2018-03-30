<?php

class Data_base {


    public function db_connexion() {

        try {
    
            return new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8',
                'webclient',
                'webpassword'
            ); 
        
        } catch(Exception $e) {
        
            die('Erreur : ' . $e->getMessage());
        
        }

    }


    public function search($search) {


        $search = '%' . $search . '%';


        $db = Data_base::db_connexion();


        $statment = $db->prepare("SELECT id, login, last_name, first_name FROM users WHERE login LIKE :search");


        $statment->execute(array(":search" => $search));


        return $statment->fetchAll(PDO::FETCH_ASSOC);

    }


    public function password_check($login, $password) {


        $db = Data_base::db_connexion();


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

?>