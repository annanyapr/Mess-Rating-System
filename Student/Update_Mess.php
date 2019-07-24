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
	$mess = $_POST['mess'];
	$rollno=$_SESSION['user'];

	$result = mysqli_query($db,"UPDATE students SET next_mess = '$mess' WHERE username = '$rollno'") or die("Failed".mysqli_error($db));
	$_SESSION['msg']="Mess Changed";
		$_SESSION['tabstudent']=0;
	header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	exit();
?>