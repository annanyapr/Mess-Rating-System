<?php
	if(isset($_SESSION['type']))
	{
	  if($_SESSION['type']=='students')
	  {
	    header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	    exit();
	  }
	  else if ($_SESSION['type']=='admin')
	  {
	    header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	    exit();
	  }
	  
	}
	if(isset($_POST['month'])&&isset($_POST['year']))
	{
		include("../config.php");
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		$_SESSION['month']=$_POST['month'];
		$_SESSION['year']=$_POST['year'];
	}
	$_SESSION['tabmess']=1;
	header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	exit();

?>