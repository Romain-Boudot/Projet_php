<?php
    session_start();

    if (!isset($_SESSION['login'])) {
        header('location: http://localhost/pages/login.php');
        exit();
    }

?>
<!DOCTYPE html>
<html>

<head>
    <title>Talk with me!</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <?php include 'include/bootstrap_css.html'; ?>
</head>

<body>
    page d'acceuil
    <br>
    <a href="http://localhost/modules/disconnect.php">déconnexion</a>
    <br>
    <a href="http://localhost/pages/existepas.html">erreur 404</a>
</body>

</html>