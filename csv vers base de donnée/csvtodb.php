<?php     

    // connection à la base de donnée

    try {
        $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'webclient', 'webpassword'); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    

    // recuperation de tout le contenue du fichier csv

    $csv = file_get_contents("users.csv");
    

    // séparation de chaque ligne => tableau d'utilisateur 

    $csv = explode("\n", $csv);
    

    // effacage des utilisateur actuelle

    //$statement = $db->query("DELETE FROM users");
    

    // pour chaque ligne du tableau ( pour chaque utilisateur )

    for($i = 0; $i < sizeof($csv); $i++) {
        

        // séparation des donnée grace au ';'

        $tempdata = explode(";", $csv[$i]);


        // préparation de la requete sql pour rentrer les informations de l'utilisateur '$i' dans la base

        $statement = $db->prepare("INSERT INTO users(sexe, last_name, first_name, login, password, active) VALUES(?, ?, ?, ?, ?, ?)");

        
        // éxécution de la requete avec les donnée du tableau '$tempdata'

        $statement->execute($tempdata);

    }


    // on efface la connexion à la base de donnée

    $db = null;    
    
?>