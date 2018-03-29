<?php     


    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

    // connection à la base de donnée
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'webclient', 'webpassword'); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    

    // recuperation de tout le contenue du fichier csv

    $csv = file_get_contents("utilisateurs.csv");
    

    // séparation de chaque ligne => tableau d'utilisateur 

    $csv = explode("\n", $csv);
    

    // effacage des utilisateur actuelle

    $statement = $db->query("DELETE FROM users");
    

    // pour chaque ligne du tableau ( pour chaque utilisateur )

    for($i = 1; $i < sizeof($csv); $i++) {
        

        // séparation des donnée grace au ';'

        $tempdata = explode(";", $csv[$i]);


        // préparation de la requete sql pour rentrer les informations de l'utilisateur '$i' dans la base

        $statement = $db->prepare("INSERT INTO users(civilité, last_name, first_name, email, login, password, active) VALUES(?, ?, ?, ?, ?, ?, ?)");

        
        // éxécution de la requete avec les donnée du tableau '$tempdata'

        $statement->execute($tempdata);

    }


    // on efface la connexion à la base de donnée

    $db = null;    
    
?>