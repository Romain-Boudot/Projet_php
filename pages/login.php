<?php 
    session_start();

    if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {
        
        echo "<script>alert('coucou')</script>";

        try {
            $db = new PDO('mysql:host=localhost;dbname=projet_php;charset=utf8', 'webclient', 'webpassword'); 
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    
        extract($_POST);
        
        // on recupére le password de la table qui correspond au login du visiteur
        
        $data = $db->query("SELECT id, mdp FROM test where login='" . $login . "'");

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

?>
<!DOCTYPE html>
<html>

    <head>
        <title>Identifiez-vous</title>
    </head>

    <form action="http://localhost/pages/login.php" method="post">
        
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