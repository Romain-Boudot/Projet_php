<?php 
    //demarrage ou reprise de session ! super important a mettre toujours en premier !
    session_start();

    // les variables !
    include $_SERVER['DOCUMENT_ROOT'] . '/include/var.php';
    

    if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {

        try {
            $db = new PDO($request_db, $login_db, $password_db); 
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    
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

            header('Location: http://' . $_SERVER['HTTP_HOST'] . '');
            exit();
            
        }

    }

?>
<!DOCTYPE html>

<html>

    <head>

        <title>Identifiez-vous</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
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

            <h1>MARCASSIN</h1>

            <hr>
            <br>

            <form action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/pages/login.php" method="post">
                
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