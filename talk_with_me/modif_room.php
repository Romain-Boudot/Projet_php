<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

    $room;

    if(isset($_GET) && isset($_GET['id'])) {

        $room = User::get_this_room($_GET['id']);

        if ($room != false) {
            
            if ($room->have_access($_GET['id']) == false || $room->get_var('isadmin') == 0) {
                
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
                exit();
                
            }

        } else {

            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
            exit();

        }
            
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <?php 
        $title = 'Marcassin';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    ?>

</head>

<body class="pt-90px resp-resize white-filter">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>

    <input id="current_id" type="hidden" value="<?php echo $_SESSION['user']['id']; ?>">
    <input id="room_id" type="hidden" value="<?php echo $_GET['id']; ?>" />

    <div class="container mw-900">

        <div id="modif_container" class='container p-4 text-center'>

            <h2>Modifier la salle</h2>

            <hr>
            <br>

            <div class="container">

                <label class="resp-label-572">Nom de la salle</label>
                <div class="input-group mb-3 resp-572-rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input value='<?php echo $room->get_var('name'); ?>' type="text" id="name" class="form-control" maxlength="30" placeholder="random things" />
                </div>

                <label class="resp-label-572">Nom d'Utilisateur</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend resp-572-rounded">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon2" style="width: 180px;">Recherche d'utilisateur</span>
                    </div>
                    <input id="search" type="text" class="form-control" placeholder="Pseudo" onkeyup="search_db(this.value)" />
                </div>

                <div id="search_result" class="p-2 border text-left mb-1" style="display: none">
                    <div id="search_result_title">Résultats de la recherche<hr></div>
                    <div id="search_element"></div>
                </div>

                <div id="invited_users" class="container p-3 w-100 border text-left">
                    <div id="nobody_added" style="display: block">Il n'y a personne ici !</div>
                </div>

                <a role="button" class="btn btn-secondary mr-3 mt-3" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Annuler</a>
                <button type="button" onclick="send_creation()" class="btn btn-primary mt-3">Modifier</button>

            </div>

        </div>

    </div>

    <script src="/javascript/search.js"></script>
    <script src="/javascript/modif_room.js"></script>

</body>

</html>