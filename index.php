<?php
    //demarrage ou reprise de session ! super important a mettre toujours en premier !
    session_start();

    // test de connexion au site
    if (!isset($_SESSION['login'])) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/pages/login.php");
        exit();
    }

    // les variables !
    include $_SERVER['DOCUMENT_ROOT'] . '/include/var.php';

    //on recupe les room
    try {
        $db = new PDO($request_db, $login_db, $password_db); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $data = $db->query(
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
        WHERE userid = '".$_SESSION['id']."'");

    $data = $data->fetchAll(PDO::FETCH_ASSOC);

    function get_basic_room($name, $author, $last_message, $id) {
        echo "<div class='jumbotron jumbotron-fluid border border-secondary rounded p-0 clickable' onclick='alert(\"$id\")'>";
            
        echo '<div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-secondary p-2">';
        echo $name;
        echo '</div>';

        echo '<div class="d-inline-flex p-2">';
        echo $author;
        echo '</div>';

        echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
        echo $last_message;        
        echo '</div>';
        
        echo '</button>';
    }

    function get_admin_room($name, $author, $last_message, $id) {
        echo '<div class="jumbotron jumbotron-fluid border border-primary rounded p-0">';
            
        echo '<div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-primary p-2">';
        echo $name;
        echo '</div>';

        echo '<div class="d-inline-flex p-2">';
        echo $author;
        echo '</div>';

        echo '<div class="w-100 bg-primary text-white p-4 text-truncate">';
        echo $last_message;
        echo '</div>';
        
        echo '</div>';
    }

    function get_validation_room($name, $author, $id) {
        echo '<div class="jumbotron jumbotron-fluid border border-success rounded p-0">';
            
        echo '<div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-success p-2">';
        echo $name;
        echo '</div>';

        echo '<div class="d-inline-flex p-2">';
        echo $author;
        echo '</div>';

        echo '<div class="d-flex bg-success text-white p-4">';

        echo  '<a class="btn btn-light mr-3 p-1" href="#" role="button">accepter</a>';
        echo  '<a class="btn btn-danger p-1" href="#" role="button">refuser</a>';

        echo '</div>';
        
        echo '</div>';
    }

?>
<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <?php echo $bootstrap_css; ?>
      
</head>

<body>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <a class='btn btn-outline-secondary ml-4' href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/pages/create_room.php" role="button">Créer une salle</a>
            <button type="button" class="btn btn-outline-secondary ml-2">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>
    
    <div id="room_container" class="container">

        <?php

            if(!is_null($data[0]['name'])) {
    
                for($i = 0; $i < sizeof($data); $i++) {
                    
                    if($data[$i]['isadmin'] === "1") {
                        get_admin_room($data[$i]['name'], $data[$i]['author'], " testeuuuuuuu", $data[$i]['rid']);
                    } else if($data[$i]['isvalidate'] === "0") {
                        get_validation_room($data[$i]['name'], $data[$i]['author'], $data[$i]['id']);
                    } else {
                        get_basic_room($data[$i]['name'], $data[$i]['author'], " testeuuuuuuu", $data[$i]['rid']);
                    }
                    
                }
            
            } else {

                echo "<div class='jumbotron jumbotron-fluid border border-secondary rounded p-4'>";
                echo "<p class='d-inline'>Vous n'avez accès à aucune salle, mais vous pouvez en créer une !</p>";
                echo "</div>";

            }

        ?>

    </div>

</body>

</html>