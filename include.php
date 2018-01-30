<?php // THIS CAN ONLY BE INCLUDE

    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');


    // include des objets

    include $_SERVER['DOCUMENT_ROOT'] . '/object/user.php';

    /* include $_SERVER['DOCUMENT_ROOT'] . '/object/data_base.php';
    $data_base = new Data_base_old(); // initialisation de l'objet base de donnée

    include $_SERVER['DOCUMENT_ROOT'] . '/object/printer.php';
    $printer = new Printer(); //initialisation de l'objet printer ( affichage d'html ) */

    
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

?>