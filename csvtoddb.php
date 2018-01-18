<?php 

    try {
        $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'webclient', 'webpassword'); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $csv = file_get_contents("users.csv");

    $csv = explode("\n", $csv);

    for($i = 0; $i < sizeof($csv); $i++) {
        $tempdata = explode(";", $csv[$i]);
        $statement = $db->prepare("INSERT INTO users(sexe, last_name, first_name, login, password, active)
        VALUES(?, ?, ?, ?, ?, ?)");
        $statement->execute(array($tempdata[0], $tempdata[1], $tempdata[2], $tempdata[3], $tempdata[4], $tempdata[5]));
    }

    $db = null;

?>