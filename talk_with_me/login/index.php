<?php 
    // load or reload a session ! have to be the first line
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';

    // check if session is up
    if (isset($_SESSION['login'])) {
        header('location: http://' . $_SERVER['HTTP_HOST']);
        exit();
    }

    if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {

        $db = data_base_connexion();
    
        extract($_POST);
        
        // on recupére le password de la table qui correspond au login du visiteur
        $data = $db->query("SELECT id, password, last_name, first_name, active FROM users where login='" . $login . "'");

        $data = $data->fetch();

        if ( $data['password'] != $password || $data['active'] == 0) {

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