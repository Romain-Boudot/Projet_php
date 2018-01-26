<?php // THIS CAN ONLY BE INCLUDE

    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');


    // include des objets

    include $_SERVER['DOCUMENT_ROOT'] . '/object/data_base.php';
    $data_base = new Data_base(); // initialisation de l'objet base de donnée

    include $_SERVER['DOCUMENT_ROOT'] . '/object/printer.php';
    $printer = new Printer(); //initialisation de l'objet printer ( affichage d'html )

    
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
    

    function login_test($test) {

        if (!isset($_SESSION['login'])) {
            
            if ($test == 'login') {
            
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login');
                exit();

            } else if ($test != 'home') {

                echo $test;
                exit();
            
            }

        } else {
            
            if ($test == 'home') {
                
                header('location: http://' . $_SERVER['HTTP_HOST']);
                exit();
            }

        }
            
    }

    /* if ($test == 'login') header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/login');
    else echo $test;
    exit(); */

?>