<?php



    header("Content-Type: text/event-stream");
    header("Cache-Control: no-cache");
    
    function sendMsg($roomid, $msg) {

        echo "event: room_target:" . $roomid . PHP_EOL;
        echo "data: $msg" . PHP_EOL;
        echo PHP_EOL;
        ob_flush();
        flush();

    }


    while(1) {

        $start += 1;

        sendMsg(18, $start);

        sleep(1);
    }



?>