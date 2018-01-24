<?php // THIS CAN ONLY BE INCLUDE

    $_SERVER['HTTP_HOST']; //adress of the loaded page

    $bootstrap_css      =   '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">';
    
    $bootstrap_js       =   '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>' .
                            '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>' . 
                            '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>';

    // url to :
    $location_login     =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login';
    $location_create    =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/create_room';
    $location_modify    =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/modify_room/index.php';
    $location_room      =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room/index.php';

    // module :
    $create_room_module =   $_SERVER['DOCUMENT_ROOT'] . '/modules/send_creation_request.php';
    $delete_room_module =   $_SERVER['DOCUMENT_ROOT'] . '/modules/send_delete_request.php';

    // path on the server
    $path_login         =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/login';
    $path_create        =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/create_room';
    $path_delete        =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/modify_room';
    $path_room          =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/room';

    // fonction :
    // - login_test()
    // - data_base_connexion() return dabase PDO objet
    

    function login_test() {

        if (!isset($_SESSION['login'])) {
        
            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login');
            exit();
        
        }
    
    }

    function data_base_connexion() {

        // pdo request
        $request_db         =   'mysql:host=localhost;dbname=projet_php;charset=utf8';
        $login_db           =   'webclient';
        $password_db        =   'webpassword';
        
        try {
        
            return new PDO($request_db, $login_db, $password_db); 
        
        } catch(Exception $e) {
        
            die('Erreur : ' . $e->getMessage());
        
        }

    }

    function get_basic_room($name, $author, $last_message, $id) {
    
        echo '<div class="row jumbotron jumbotron-fluid border border-secondary rounded p-0 clickable" onclick="location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/pages/room.php?id=' . $id . '\'">';        
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-secondary p-2 text-center">';
        echo $name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $author;
        echo '</div>';
        echo '<div class="col"></div>';
        echo '<div class="w-100 bg-secondary text-white p-4 text-truncate">';
        echo $last_message;        
        echo '</div>';
        echo '</button>';

    }

    function get_admin_room($name, $author, $last_message, $id) {

        echo '<div class="row jumbotron jumbotron-fluid border border-primary rounded p-0 clickable" onclick="location.href=\'http://' . $_SERVER['HTTP_HOST'] . '/pages/room.php?id=' . $id . '\'">';
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-primary p-2 text-center">';
        echo $name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $author;
        echo '</div>';
        echo '<div class="col"></div>';
        echo '<div class="w-100 bg-primary text-white p-4 text-truncate">';
        echo $last_message;
        echo '</div>';    
        echo '</div>';
    
    }

    function get_validation_room($name, $author, $id) {

        echo '<div class="row jumbotron jumbotron-fluid border border-success rounded p-0">';
        echo '<div class="col border border-bottom-0 border-left-0 border-top-0 border-success p-2 text-center">';
        echo $name;
        echo '</div>';
        echo '<div class="col p-2">';
        echo $author;
        echo '</div>';
        echo '<div class="col"></div>';
        echo '<div class="w-100 bg-success text-white p-4 ">';
        echo '<a class="btn w-25 minw-100px btn-light mr-3 p-1" href="#" role="button">accepter</a>';
        echo '<a class="btn w-25 minw-100px btn-danger p-1" href="#" role="button">refuser</a>';
        echo '</div>';
        echo '</div>';
    
    }

?>