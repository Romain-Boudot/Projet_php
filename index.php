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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
</head>

<body>
    
    <nav class="navbar fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="http://localhost">Navbar</a>

        <div class="d-flex">

            <span class="navbar-text text-warning"><?php echo $_SESSION['login']; ?></span>
            <button type="button" class="btn btn-outline-secondary ml-4">
                Notifications<span class="badge badge-light ml-1">4</span>
            </button>
            <a class="btn btn-outline-secondary ml-2" href="http://localhost/modules/disconnect.php" role="button">deconnexion</a>
        </div>

    </nav>
    
    <div id="room_container" class="container">

        <div class="jumbotron jumbotron-fluid border border-secondary rounded p-0">
            
            <div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-secondary p-2">
                Nom de la discussion
            </div>

            <div class="d-inline-flex p-2">
                Autheur de la disscusion
            </div>

            <div class="w-100 bg-secondary text-white p-4 text-truncate">
                dernier message ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
            </div>
        
        </div>

        <div class="jumbotron jumbotron-fluid border border-primary rounded p-0">
            
            <div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-primary p-2">
                Nom de la discussion
            </div>

            <div class="d-inline-flex p-2">
                Autheur de la disscusion
            </div>

            <div class="w-100 bg-primary text-white p-4 text-truncate">
                dernier message
            </div>
        
        </div>

        <div class="jumbotron jumbotron-fluid border border-success rounded p-0">
            
            <div class="d-inline-flex border border-bottom-0 border-left-0 border-top-0 border-success p-2">
                Nom de la discussion
            </div>

            <div class="d-inline-flex p-2">
                Autheur de la disscusion
            </div>

            <div class="d-flex bg-success text-white p-4">

                <a class="btn btn-light mr-3 p-1" href="#" role="button">accepter</a>
                <a class="btn btn-danger p-1" href="#" role="button">refuser</a>

            </div>
        
        </div>

    </div>

</body>

</html>