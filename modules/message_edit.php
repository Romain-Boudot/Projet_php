<?php

$db = db_connection();

$statement = $db->prepare("UPDATE message SET message = :messageid WHERE roomid = :roomid");

$stat

$statement->execute(array());

?>