<?php 

    $head = $_SERVER['PHP_SELF'];
    $head = explode("/", $head);

    if(isset($_POST)) {

        try {
            $db = new PDO('mysql:host=localhost;dbname=serveur;charset=utf8', 'webclient', 'webpassword'); 
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    
        if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {
    
            extract($_POST);
            
            // on recupére le password de la table qui correspond au login du visiteur
            
            $data = $db->query("SELECT id, mdp FROM membre where login='" . $login . "'");
    
            $data = $data->fetch();
    
            if ( $data['mdp'] != $password ) {

                setcookie('login', $login, time() + 24*3600*7);
            
            } else {
                
                setcookie('login', $login, time() + 24*3600*7, null, null, false, true);
                $_SESSION['id'] = $data['id'];
                $_SESSION['login'] = $login;
    
                header('Location: http://localhost');
                exit();
                
            }
    
        }

    }

?>
<!DOCTYPE html>
<html>

    <head>
        <title> <?php echo $head[4]; ?> </title>
    </head>

    <?php

        if ($head[4] === 'login') {
            echo 'login';
        } else if ($head[4] === 'register') {
            echo 'register';
        }

        if (isset($_SESSION['login'])) {
            echo '<br>'.$_SESSION['login'];
        }

    ?>

    <form action="http://localhost/index/login" method="post">
        
        <?php 
            if(isset($_COOKIE['login']))
                echo "<input type='text' name='login' value='".$_COOKIE['login']."'>";
            else
                echo "<input type='text' name='login'>";
        ?>
        <input type="password" name="password">
        <button type="submit">connect</button>
    </form>

</html>