<?php

	include("../config.php");
	

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	session_unset();
    header("Location: http://{$_SERVER['HTTP_HOST']}/Login/login.php");
	exit();

?>