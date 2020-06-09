<?php
	session_start();
	session_destroy();//Выход из сессии
	
	header("Location: ../index.php");				
	exit;
?>
