<div id="menu-trigger" class="clickable">
    <span id="btn_slide_menu_trigger" class="fixed btn-menu txt-dark hover-txt-black fas fa-bars"></span>
</div>
<a id="logo-txt" class="hover-txt-black txt-dark navbar-brand" href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>MARCASSIN</a>
<nav class="navbar fixed-top white navbar-white shadow-2">
    <div class="d-flex"></div>
    
    <div class="d-flex">
        <div class="txt-dark"><?php echo $_SESSION['user']['login']; ?></div>
    </div>

</nav>

<div id="slide_menu" class="container bg-dark text-center">

    <ul>

        <!-- <li><a href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'>Accueil</a></li> -->

        <?php

            if (isset($modif_room)) {

                if ($room->get_var('isadmin') == 1) { ?>

                    <li><div class="clickable" onclick="location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/modif_room.php?id=<?php echo $_GET['id'] ?>'" >Modifier la salle</div></li>

                <?php }
            } else { ?>

                <li><div class="clickable" onclick="location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/talk_with_me/create_room.php'" >Créer une salle</div></li>

            <?php }

        ?>

        <li></li>

    </ul>

    <ul class="bottom-float">
        <li><div class="clickable" onclick="location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/modules/disconnect.php'">Déconnexion</div></li>
    </ul>

</div>

<div id="black-filter-menu"></div>

<script>

    function menu_show() {
        $('#slide_menu').css('transform', 'none')
        $('.resp-resize').css('width', 'calc(100vw - 250px)')
        $('#logo-txt').css('color', 'white')
        $('#btn_slide_menu_trigger').css('color', 'white');
        if ($(window).width() <= 850) {
            $('#black-filter-menu').css('display', 'block');
            setTimeout(() => {
                $('#black-filter-menu').css('opacity', '1');
            }, 50);
        }
    }

    function menu_hide() {
        $('#slide_menu').css('transform', 'translateX(-250px)');
        $('.resp-resize').css('width', '100vw');
        $('#logo-txt').css('color', 'rgb(65, 65, 65)');
        $('#btn_slide_menu_trigger').css('color', 'rgb(65, 65, 65)');
        if ($(window).width() <= 850) {
            $('#black-filter-menu').css('opacity', '0');
            setTimeout(() => {
                $('#black-filter-menu').css('display', 'none');
            }, 200);
        }
    }

    $(document).ready(function(){

        $(window).resize(function() {
            if ($(window).width() >= 850) {
                menu_show();
            } else {
                menu_hide();
            }
        })

        $('#menu-trigger').on('click', function() {
            if ($('#slide_menu').css('transform') == 'none') {
                menu_hide();
            } else {
                menu_show();
            }
        })

        $('#black-filter-menu').on('click', function() {
            menu_hide();
        })

    })

</script>