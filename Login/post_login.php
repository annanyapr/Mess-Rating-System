<?php

include("../config.php");
	    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

	$username = $_POST['username'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	if($username=='admin')
	{
		if($password=='admin')
		{
			$_SESSION['user'] =  $username;
			$_SESSION['type'] =  'admin';
			header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
			exit();
		}
		else
		{
			$_SESSION['msg']="Login Failed";
			header("Location: http://{$_SERVER['HTTP_HOST']}/Login/login.php");
			exit();
		}

	}
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysqli_real_escape_string($db,$username);
	$password = mysqli_real_escape_string($db,$password);
	$type = mysqli_real_escape_string($db,$type);


	$password = md5($password);


	$result = mysqli_query($db,"SELECT * FROM $type WHERE username = '$username' AND password = '$password'") or die("Failed".mysqli_error($db));

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	if ($row['username'] == $username && $row['password'] == $password){
		$_SESSION['user'] =  $username;
		$_SESSION['type'] =  $type;
		 if($type== 'students')
		{	
			 header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
			exit();
		}
		else
		{
			header("Location: http://{$_SERVER['HTTP_HOST']}/MessManager/home.php");
		 	exit();
		}
	}
	else{
		$_SESSION['msg']="Login Failed";
		header("Location: http://{$_SERVER['HTTP_HOST']}/Login/login.php");
		exit();
	}


	?>