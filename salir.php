<?php
	session_start();
	session_unset();
	session_destroy();
	include 'cons.php';
	header('Location: '.ROOT);
?>