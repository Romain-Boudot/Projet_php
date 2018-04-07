<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

?>
<!DOCTYPE html>
<html lang='fr'>

<head>

    <?php 
        $title = 'Marcassin';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    ?>

</head>

<body class="pt-90px resp-resize white-filter">

    <div id="current_id" hidden><?php echo $_SESSION['user']['id']; ?></div>
    <div id="room_id" hidden>-1</div>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>

    <div class="container mw-900">

        <div id="creation_container" class='container p-4 text-center'>

            <h2>Création de salle</h2>

            <hr>
            <br>

            <div class="container">

                <label class="resp-label-572">Nom de la salle</label>
                <div class="input-group mb-3 resp-572-rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input type="text" id="name" class="form-control" maxlength="30" placeholder="random things"/>
                </div>

                <label class="resp-label-572">Nom d'Utilisateur</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend resp-572-rounded">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon2" style="width: 180px;">Recherche d'utilisateur</span>
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

    <script src="/javascript/search.js"></script>
    <script src="/javascript/create_room.js"></script>

</body>


</html>