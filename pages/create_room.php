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

    //connexion à la base de donnée
    try {
        $db = new PDO($request_db, $login_db, $password_db); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    function get_users() {

        $users = $db->query("SELECT id, login, last_name, first_name FROM users");
    
        $users = $users->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Prenom</th>';
        echo '<th scope="col">Nom</th>';
        echo '<th scope="col">Pseudo</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        
        for($i = 0; $i < sizeof($users); $i++) {
            if ($users[$i]['id'] == $_SESSION['id']) continue;
            echo '<tr>';
            echo '<th scope="row">' . $users[$i]['first_name'] . '</th>';
            echo '<th scope="row">' . $users[$i]['last_name'] . '</th>';
            echo '<th scope="row">' . $users[$i]['login'] . '</th>';
            echo '</tr>';
        }
              
        echo '</tbody>';
        echo '</table>';

    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>Création de page</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
</head>

<body>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">MARCASSIN</a>
        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <button type="button" class="btn btn-outline-secondary ml-4">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">deconnexion</a>
        </div>

    </nav>

    <div id="creation_container" class="container">

        <div id="wrapper" class='container border rounded p-4 text-center'>

            <h2>Création de salle</h2>

            <hr>
            <br>

            <form action="post">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Nom de la salle</span>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="random things">

                    
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Nom de la salle</span>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="random things">
                    
                </div>  

                </div>
                
            </form>

        </div>

    <div>

</body>

</html>