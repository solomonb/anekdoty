<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	
	$host = 'localhost'; 
	$user = 'root'; 
	$password = ''; 
	$db_name = 'anekdoty';
	
	$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link));	
	mysqli_query($link, "SET NAMES 'utf8'");

	
	