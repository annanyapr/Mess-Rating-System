<?php

	include("../config.php");
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if(isset($_SESSION['type']))
	{
	  if($_SESSION['type']=='mess_manager')
	  {
	    header("Location: http://{$_SERVER['HTTP_HOST']}/MessManager/home.php");
	    exit();
	  }
	        else if ($_SESSION['type']=='admin')
	  {
	    header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	    exit();
	  }
	  
	}
	    else
	{
	    header("Location: http://{$_SERVER['HTTP_HOST']}/Login/login.php");
	    exit();
	}
	$_SESSION['month']=$_POST['month'];
	$_SESSION['year']=$_POST['year'];
	$_SESSION['tabstudent']=2;
	header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	exit();

?>