<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();


    // check if session is up

    login_test('[[-2]]');


    // we return some json array

    header("Content-type: text/javascript");

    
    if(!isset($_GET) || !isset($_GET['id'])) {
        echo '[[-1]]';
        exit();
    }

    $db = Data_base::db_connexion();

    $statment = $db->prepare("SELECT userid FROM assouser WHERE roomid = :id");

    $statment->execute(array(
        ":id" => $_GET['id']
    ));

    $answer = $statment->fetchAll(PDO::FETCH_ASSOC);
    echo '[[';

    for ($cpt = 0; $cpt < sizeof($answer); $cpt++) {

        if ($cpt > 0) echo ',';
        echo "\"" . $answer[$cpt]['userid'] . "\"";

    }

    echo ']';

    $statment = $db->prepare("SELECT login, last_name, first_name FROM users u WHERE EXISTS (SELECT * FROM assouser a WHERE roomid = :roomid AND u . id = a . userid)");

    $statment->execute(array(
        ":roomid" => $_GET['id']
    ));

    $answer = $statment->fetchAll(PDO::FETCH_ASSOC);

    echo ',[';

    for ($cpt = 0; $cpt < sizeof($answer); $cpt++) {

        if ($cpt > 0) echo ',';
        echo "[";
        echo "\"" . $answer[$cpt]['login'] . "\",\"" . $answer[$cpt]['last_name']. "\",\"" . $answer[$cpt]['first_name'] . "\"";
        echo "]";

    }

    echo ']]';

?>