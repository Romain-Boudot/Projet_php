<!DOCTYPE html>
<html>

<head>
    <title>erreur 404</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="../css/404.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
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