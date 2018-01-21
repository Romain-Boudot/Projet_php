<?php
    // we return some json array
    header("Content-type: text/javascript");

    if(isset($_GET) && isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        echo 'Faut pas charcher les pages à la main !!! ';
        exit();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/include/var.php';

    try {
        $db = new PDO($request_db, $login_db, $password_db); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // we are searching for users
    $users = $db->query("SELECT id, login, last_name, first_name FROM users WHERE login like '%" . $search . "%'");

    $users = $users->fetchAll(PDO::FETCH_ASSOC);

    if(sizeof($users) > 15) {
        echo "[[-1]]";
        exit;
    }
    
    echo "[";
    for($i = 0; $i < sizeof($users); $i++) {
        if($i > 0) echo ",";
        echo "[" . $users[$i]['id'] . ",\"" . $users[$i]['login'] . "\",\"" . $users[$i]['last_name'] . "\",\"" . $users[$i]['first_name'] . "\"]";
    }
    echo "]";

    // finish

?>