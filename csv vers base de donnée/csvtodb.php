<?php     

    try {
        $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'webclient', 'webpassword'); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $csv = file_get_contents("users.csv");
    
    $csv = explode("\n", $csv);
    
    $statement = $db->query("DELETE FROM users");
    
    for($i = 0; $i < sizeof($csv); $i++) {
        $tempdata = explode(";", $csv[$i]);
        $statement = $db->prepare("INSERT INTO users(sexe, last_name, first_name, login, password, active) VALUES(?, ?, ?, ?, ?, ?)");
        $statement->execute($tempdata);
    }

    $db = null;    
    
?>