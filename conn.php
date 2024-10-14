<?php
	$conn = new mysqli('localhost', 'root', '', 'pos_coffee');
	$conn->set_charset("utf8");
	
	if(!$conn){
		die("Error: Can't connect to database");
	}
?>