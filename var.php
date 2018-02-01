<?php

    session_start();

    echo '<pre>';
    echo print_r($_SESSION['user']);
    echo '</pre>';

?> 