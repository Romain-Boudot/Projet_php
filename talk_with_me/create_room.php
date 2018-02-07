<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

?>
<!DOCTYPE html>
<html>

<head>

    <title>Création de salle</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" href="../../main.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

</head>

<body>

    <div id="current_id" hidden><?php echo $_SESSION['user']->get_var('id') ?></div>
    <div id="room_id" hidden>-1</div>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>

        <div class="d-flex">
            <span class="navbar-text text-warning"><?php echo $_SESSION['user']->get_var("login"); ?></span>
            <a class='btn btn-outline-secondary ml-4' href="<?php echo $location_create; ?>" role="button">Créer une salle</a>
            <button type="button" class="btn btn-outline-secondary ml-2">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
        </div>

    </nav>

    <div id="creation_container" class="container mw-900">

        <div class='container border rounded p-4 text-center bg-light'>

            <h2>Création de salle</h2>

            <hr>
            <br>

            <div class="container">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input type="text" id="name" class="form-control" maxlength="30" placeholder="random things"/>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2" style="width: 180px;">Recherche d'utilisateur</span>
                    </div>
                    <input id="search" type="text" class="form-control" placeholder="Pseudo" onkeyup="search_db(this.value)"/>
                </div>

                <div id="search_result" class="p-2 border text-left mb-1" style="display: none">
                    <div id="search_result_title">Résultats de la recherche<hr></div>
                    <div id="search_element"></div>
                </div>

                <div id="invited_users" class="container p-3 w-100 border text-left">
                    <div id="nobody_added" style="display: block">Vous n'avez ajouté personne dans votre salle.</div>
                </div>

                <a role="button" class="btn btn-secondary mr-3 mt-3" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Annuler</a>
                <button type="button" onclick="send_creation()" class="btn btn-primary mt-3">Créer</button>

            </div>

        </div>

    </div>

    <script src="../../javascript/search.js"></script>
    <script src="../../javascript/create_room.js"></script>

</body>


</html>