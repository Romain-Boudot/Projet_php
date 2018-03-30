<!DOCTYPE html>
<html>

<head>

    <?php head_include("Marcassin"); ?>

</head>

<body>
    
    <div class="jumbotron" style="text-align: center">

    <div id="container">
        <h1 class="display-3">Vous n'avez pas l'autorisation</h1>
        <p>Vous n'avez pas l'autorisation d'acceder à cette page :(</p>
        <a class="btn btn-primary btn-lg" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" role="button">Retour</a>
    </div>
    
    </div>

</body>

</html>