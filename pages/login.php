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
        <?php include '/var/www/html/include/bootstrap_css.html'; ?>
        <style>
            #wrapper{
                width: 500px;
                margin-top: 20vh;
                padding: 20px;
            }
        </style>
    </head>

    <body>

        <div id="wrapper" class="mx-auto text-center border rounded bg-light">

            <form action="http://localhost/pages/login.php" method="post">
                
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Nom d'utilisateur</span>
                    </div>
                    <input type="text" name="login" class="form-control" value="<?php if(isset($_COOKIE['login'])) echo $_COOKIE['login'];?>" >
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Mot de passe</span>
                    </div>
                    <input type="password" name="password" class="form-control" value="<?php if(isset($_COOKIE['login'])) echo $_COOKIE['login'];?>" >
                </div>

                <button class="btn btn-outline-primary" type="submit">connection</button>

            </form>
        
        </div>

    </body>

</html>