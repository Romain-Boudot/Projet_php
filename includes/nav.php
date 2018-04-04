<nav class="navbar fixed-top navbar-dark bg-dark blue-shadow">
    <div class="d-flex">
        <span id="btn_slide_menu_trigger" style="font-size: 100%" class="text-light clickable fas fa-bars"></span>
        <a class="resp-640-hd navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>
    </div>

    <div class="d-flex">
        <span class="navbar-text text-warning"><?php echo $_SESSION['user']['login']; ?></span>
        <a class="btn btn-outline-secondary ml-2 resp-640-hd" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php' >Créer une salle</a>
        <a class="btn btn-outline-secondary ml-2 resp-640-hd" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php" role="button">Déconnexion</a>
    </div>

</nav>

<div id="slide_menu" class="container bg-dark pt-2 text-center">
    <ul>
        <li><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>Accueil</a></li>
        <li><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php' >Créer une salle</a></li>
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php">Déconnexion</a></li>
    </ul>
</div>

<script>

    $(document).ready(function(){

        $('#btn_slide_menu_trigger').on('click', function() {
            console.log($('#slide_menu').css('transform'))
            if ($('#slide_menu').css('transform') == 'none') {
                $('#slide_menu').css('transform', 'translateX(210px)')
            } else {
                $('#slide_menu').css('transform', 'none')
            }
        })

    })

</script>