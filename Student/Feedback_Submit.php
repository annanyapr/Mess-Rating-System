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
	$feedback = $_POST['feedback'];
	$Result_mess= mysqli_query($db,"SELECT * FROM students WHERE username = '$rollno'") or die("Failed".mysqli_error($db));
	if($row_temp = mysqli_fetch_array($Result_mess, MYSQLI_ASSOC))
	{
		    $current_mess=$row_temp['mess'];
	}
	$feedback = stripcslashes($feedback);
	$feedback = mysqli_real_escape_string($db,$feedback);
    $month = date("m");
    $year=date("Y");
    $result_feedback= mysqli_query($db,"SELECT * FROM feedback WHERE rollno = '$rollno' AND month = '$month' AND year = '$year' ") or die("Failed".mysqli_error($db));

	$row = mysqli_fetch_array($result_feedback, MYSQLI_ASSOC);

	if ($row['rollno'] == $rollno && $row['month'] == $month && $row['year'] == $year){
		mysqli_query($db,"UPDATE feedback SET text = '$feedback' WHERE rollno = '$rollno' AND month = '$month' AND year = '$year'") or die("Failed".mysqli_error($db));
		$_SESSION['msg']="Feedback Updated";
	}	
	else{
		mysqli_query($db, "INSERT INTO feedback (month, year, rollno, text,mess) VALUES ('$month', '$year', '$rollno', '$feedback','$current_mess')");
		$_SESSION['msg']="New Feedback Recorded";
	}
	$_SESSION['tabstudent']=1;
	header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
	exit();

?>