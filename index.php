<?php
    session_start();

    $head = $_SERVER['PHP_SELF'];
    $head = explode("/", $head);

    echo $head[0] . "/" . $head[1];

    //redirection :
    if (sizeof($head) >= 5) {
        
        switch($head[4]) {
            case 'login':
            case 'register':
                if (!isset($_SESSION['login'])) {
                    header('location: http://localhost/pages/login.php');
                } else {
                    header('location: http://localhost/index');
                    exit();
                }
                break;
            case 'deconnexion':
                include './modules/disconnect.php';
                break;
            default:
                include './pages/404.php';
        }

    } else {

        if (!isset($_SESSION['login'])) {
            header('location: http://localhost/index/login');
            exit();
        } else {
            include './pages/main.php';
        }
    }

?>