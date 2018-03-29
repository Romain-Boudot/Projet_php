<?php // THIS CAN ONLY BE INCLUDE

    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);

    // include des objets
    include_once $_SERVER['DOCUMENT_ROOT'] . '/objects/User.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/objects/Data_base.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/objects/Room.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/objects/Message.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/objects/Token.php';
 
    // url to :
    $location_login     =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login.php';
    $location_create    =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/create_room.php';
    $location_modify    =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/modif.php';
    $location_room      =   'http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/room.php';

    // module :
    $create_room_module =   $_SERVER['DOCUMENT_ROOT'] . '/modules/send_creation_request.php';
    $delete_room_module =   $_SERVER['DOCUMENT_ROOT'] . '/modules/send_delete_request.php';

    // path on the server
    $path_login         =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/login.php';
    $path_create        =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/create_room.php';
    $path_delete        =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/modif.php';
    $path_room          =   $_SERVER['DOCUMENT_ROOT'] . '/talk_with_me/room.php';


    // fonction login test

    function login_test($test) {

        if (isset($_SESSION['connected'])) {

            if ($test == 'home' && $_SESSION['connected'] == true) {
                
                header('location: http://' . $_SERVER['HTTP_HOST']);
                exit();
            }
        
        } else {
    
            if ($test == 'login') {
                
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login.php');
                exit();
                
            } else if ($test != 'home') {
                
                echo $test;
                exit();
                
            }
            
        }

    }

    
    function gen_token($action, $id) {

        $_SESSION['token_list'][$action . $id] = new Token($action, $id);

        return $_SESSION['token_list'][$action . $id]->get_token();

    }


    
    function token_check($action, $id, $token) {

        if (isset($_SESSION['token_list'][$action . $id])) {
        
            $answer = $_SESSION['token_list'][$action . $id]->token_check($action, $id, $token);
            unset($_SESSION['token_list'][$action . $id]);
        
        }
        
        return $answer;

    }

    $data_base = new Data_base;

?>