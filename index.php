<?php
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';

    // test of the login of the user
    login_test();

    // connexion to the data_base
    $db = data_base_connexion();
    
    // pull the list of the available list for the user
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
        WHERE userid = '" . $_SESSION['id'] . "'");

    $data = $data->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="main.css">
    <?php echo $bootstrap_css; ?>
      
</head>

<body>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <a class='btn btn-outline-secondary ml-4' href="<?php echo $_SERVER['HTTP_HOST']; ?>" role="button">Créer une salle</a>
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