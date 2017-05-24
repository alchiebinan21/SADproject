<?php

include('commands.php');

$userId = $_GET['user_id'];
$command = new Command();
$user = $command->getMember($userId);


?>



