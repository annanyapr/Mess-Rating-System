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
	$rollno=$_SESSION['user'];
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];

	$old_password = stripcslashes($old_password);
	$new_password = stripcslashes($new_password);
	$old_password = mysqli_real_escape_string($db,$old_password);
	$new_password = mysqli_real_escape_string($db,$new_password);

	$old_password = md5($old_password);
	$new_password = md5($new_password);

	$result = mysqli_query($db,"SELECT * FROM students WHERE username = '$rollno' AND password = '$old_password'") or die("Failed".mysqli_error($db));

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	if ($row['username'] == $rollno && $row['old_password'] == $password){
		mysqli_query($db,"UPDATE students SET password = '$new_password' WHERE username = '$rollno'") or die("Failed".mysqli_error($db));
		$_SESSION['msg']="Password Updated";
	}	
	else{
		$_SESSION['msg']="Old Password is incorrect";
	}
	$_SESSION['tabstudent']=3;
	header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	exit();

?>