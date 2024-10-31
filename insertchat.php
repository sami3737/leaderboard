<?php

if(!isset($_GET['chat']))
	exit();

$file = "chat.log";
	
$fp = fopen($file, 'a');

$chat = $_GET['chat'];
fwrite($fp, "\r\n".$chat);

?>