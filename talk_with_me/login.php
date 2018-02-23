<?php 

    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/include.php';
    session_start();

    // check si une session est en cours, si non redirige vers #accueil

    login_test('home');


    $_SESSION['user'] = new User;

    $erreur = false;

    if(isset($_POST) && isset($_POST['login']) && isset($_POST['password'])) {

        $answer = $_SESSION['user']->data_base->password_check($_POST['login'], $_POST['password']);
        
        if($answer != false) {


            setcookie('login', $_POST['login'], time() + 24*3600*7, null, null, false, true);

            
            $_SESSION['user']->init($answer['id'], $answer['login'], $answer['last_name'], $answer['first_name']);
            
           
            $_SESSION['connected'] = true;


            header('Location: http://' . $_SERVER['HTTP_HOST']);
            exit();

        } else {
            
            // mot de passe incorect ou erreur
                
            $erreur = true;
            
        }

    }

?>
<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, userscalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <link rel="stylesheet" href="../../main.css">
        <title>Identifiez-vous</title>

    </head>

    <body>

        <div id="wrapper" class="mx-auto text-center border rounded bg-light">

            <h1>MARCASSIN</h1>

            <hr>
            <br>

            <form action="<?php echo $location_login . '/index.php' ; ?>" method="post">
                
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Nom d'Utilisateur</span>
                    </div>
                    <input type="text" name="login" class="form-control<?php if ($erreur == true) echo " is-invalid"; ?>" id="basic-addon1" value="<?php if (isset($_COOKIE['login'])) echo $_COOKIE['login'];?>" >
                </div>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Mot De Passe</span>
                    </div>
                    <input type="password" name="password" class="form-control<?php if ($erreur == true) echo " is-invalid"; ?>" id="basic-addon1"value="<?php if (isset($_COOKIE['login'])) echo $_COOKIE['login'];?>" >
                <?php if ($erreur == true) echo "<div class='invalid-feedback'> Nom d'utilisateur ou mot de passe erroné </div>"; ?>
                </div>

                <button class="btn btn-outline-primary" type="submit">connexion</button>

            </form>
        
        </div>

    </body>

</html>