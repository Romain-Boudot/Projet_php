<?php

    if (isset($_GET['dir'])) {
        header('location: http://localhost/index/'.$_GET['dir']);
    } else {
        header('location: http://localhost');
    }

?>