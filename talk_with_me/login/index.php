<?php 
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';

    // Afficher les erreurs à l'écran
    ini_set('display_errors', 1);
    // Enregistrer les erreurs dans un fichier de log
    ini_set('log_errors', 1);
    // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
    ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

    if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {

        $db = data_base_connexion();
    
        extract($_POST);
        
        // on recupére le password de la table qui correspond au login du visiteur
        $data = $db->query("SELECT id, password, last_name, first_name FROM users where login='" . $login . "'");

        $data = $data->fetch();

        if ( $data['password'] != $password ) {

            // code mot de passe incorecte
        
        } else {
            
            setcookie('login', $login, time() + 24*3600*7, null, null, false, true);
            $_SESSION['id'] = $data['id'];
            $_SESSION['last_name'] = $data['last_name'];
            $_SESSION['first_name'] = $data['first_name'];
            $_SESSION['login'] = $login;

            header('Location: http://' . $_SERVER['HTTP_HOST']);
            exit();
            
        }

    }

?>
<!DOCTYPE html>

<html>

    <head>

        <title>Identifiez-vous</title>
        <link rel="stylesheet" href="../../main.css">
        <?php echo $bootstrap_css ; ?> 

    </head>

    <body>

        <div id="wrapper" class="mx-auto text-center border rounded bg-light">

            <h1>MARCASSIN</h1>

            <hr>
            <br>

            <form action="<?php echo $location_login . '/index.php' ; ?>" method="post">
                
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

                <button class="btn btn-outline-primary" type="submit">connexion</button>

            </form>
        
        </div>

    </body>

</html>