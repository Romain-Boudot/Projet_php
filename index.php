<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();

    // check si une session est en cours, si non redirige vers #login
    login_test('login');

?>

<!DOCTYPE html>
<html>

<head>

    <?php 
        $title = 'Marcassin';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
    ?>
      
</head>

<body class="pt-80px pb-80px">

    <input type='hidden' id="current_id" value='<?php echo $_SESSION['user']['id']; ?>'>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>
    
    <div class="container">

            
        <?php User::print_users_rooms(); ?>
            
        
    </div>

</body>

</html>