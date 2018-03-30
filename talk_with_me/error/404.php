<!DOCTYPE html>
<html>

<head>

    <?php 
        $title = 'Marcassin';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    ?>

</head>

<body>
    
    <div class="jumbotron" style="text-align: center">

    <div id="container">
        <h1 class="display-3">erreur 404</h1>
        <p>Votre page est introuvable</p>
        <a class="btn btn-primary btn-lg" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" role="button">Retour</a>
    </div>
    
    </div>

</body>

</html>