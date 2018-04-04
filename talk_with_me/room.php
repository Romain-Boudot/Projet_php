<?php
    // load or reload a session ! have to be the first line
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/include.php';
    session_start();

    // test of the login of the user
    login_test('login');

    if(isset($_GET) && isset($_GET['id'])) {

        $room = User::get_this_room($_GET['id']);

        if ($room != false) {
            
            if ($room->have_access($_GET['id']) == false) {
                
                header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
                exit();
                
            }

        } else {

            header('location: http://' . $_SERVER['HTTP_HOST'] . '/talk_with_me/error/denied.php');
            exit();

        }
            
    }

    $token = bin2hex(mcrypt_create_iv(42, MCRYPT_DEV_URANDOM));

    $db = Data_base::db_connexion();

    $statment = $db->prepare("UPDATE users SET token = :token WHERE id = :id");

    $statment->execute(array(
        ":token" => $token,
        ":id" => $_SESSION['user']['id']
    ));

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

    <input id="current_room" type="hidden" value="<?php echo $_GET['id']; ?>">
    <input id="current_id" type="hidden" value="<?php echo $_SESSION['user']['id']; ?>">
    <input id="tokenUser" type="hidden" value="<?php echo $token; ?>">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/modif_room.php'; ?>

    <div id="messages_container" style="scroll-behavior: smooth;" class="mw-1200 mt-100px container-fluid">
        
        <?php User::get_this_room($_GET['id'])->print_messages(); ?>

    </div>

    <div id="send_bar" class="p-2 w-100 bg-grey fixed-bottom">

        <div class="input-group mw-1200 container-fluid">
            <input id="message" type="text" class="form-control" placeholder="Message" maxlength="1000">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="send_message()">Envoyer</button>
            </div>
        </div>

    </div>

    <script src="/javascript/message.js"></script>
    
</body>

</html>