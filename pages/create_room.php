<?php
    // load or reload a session ! have to be the first line
    session_start();

    // test of the login of the user
    if (!isset($_SESSION['login'])) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/pages/login.php");
        exit();
    }

    // variable
    include $_SERVER['DOCUMENT_ROOT'] . '/include/var.php';

    // connection to the database
    try {
        $db = new PDO($request_db, $login_db, $password_db); 
    } catch(Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>Création de salle</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <?php echo $bootstrap_css; ?>    
</head>

<body>

    <div id="current_id" hidden><?php echo $_SESSION['id'] ?></div>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">MARCASSIN</a>
        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <button type="button" class="btn btn-outline-secondary ml-4">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>

    <div id="creation_container" class="container">

        <div id="wrapper" class='container border rounded p-4 text-center bg-light'>

            <h2>Création de salle</h2>

            <hr>
            <br>

            <div class="container">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input type="text" id="name" class="form-control" placeholder="random things">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 180px;">Recherche d'utilisateur</span>
                    </div>
                    <input id="search" type="text" class="form-control" placeholder="Pseudo, nom ou prénom" onkeyup="search_db(this.value)">
                </div>

                <div id="search_result" class="p-2 border text-left mb-1" style="display: none">
                    <div id="search_result_title">Résultats de la recherche<hr></div>
                    <div id="search_element"></div>
                </div>

                <div id="invited_users" class="container p-3 w-100 border text-left">
                    <div id="nobody_added" style="display: block">
                        Vous n'avez ajouté personne dans votre salle.
                    </div>
                </div>

                </div>

                <a role="button" class="btn btn-secondary mr-3 mt-3" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Annuler</a>
                <button type="button" onclick="send_creation()" class="btn btn-primary mt-3">Valider</button>

            </div>

        </div>

    <div>

    <script src="../javascript/room_settings.js"></script>
</body>


</html>