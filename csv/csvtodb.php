<?php     


    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
    set_time_limit(10000000000000);
    // connection à la base de donnée
    
    try {
        $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'root', ''); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    

    // recuperation de tout le contenue du fichier csv

    $csv = file_get_contents("utilisateurs.csv");
    


    // séparation de chaque ligne => tableau d'utilisateur 

    $csv = explode("\n", $csv);
    
    $allready_added_user_login = array();

    // effacage des utilisateur actuelle

    $statement = $db->query("DELETE FROM users");
    
    
    // pour chaque ligne du tableau ( pour chaque utilisateur )

    $cpt = 0;

    for($i = 1; $i < sizeof($csv); $i++) {
        

        // séparation des donnée grace au ';'

        $tempdata = explode(";", $csv[$i]);

        // // Génère une valeur de hachage
        // $code = strlen($tempdata[5]);

        
        if (isset($allready_added_user_login[$tempdata[4]])) continue;
        else $allready_added_user_login[$tempdata[4]] = true;
        
        $hash_mdp = hash("sha512", $tempdata[5], false);
        $cpt++;

        // préparation de la requete sql pour rentrer les informations de l'utilisateur '$i' dans la base

        $statement = $db->prepare("INSERT INTO users(civilité, last_name, first_name, email, login, password, active) VALUES(?, ?, ?, ?, ?, ?, ?)");

        // éxécution de la requete avec les donnée du tableau '$tempdata'

        $statement->execute(array($tempdata[0], $tempdata[1], $tempdata[2], $tempdata[3], $tempdata[4], $hash_mdp, $tempdata[6]));
        
        
        echo $cpt . PHP_EOL;
        
    }

    // on efface la connexion à la base de donnée
        
    $db = null;    
    
?>