<?php

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
             else       if($_SESSION['type']=='students')
       {
         header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
         exit();
       }
       
     }
         else
     {
         header("Location: http://{$_SERVER['HTTP_HOST']}/Login/login.php");
         exit();
     }
include("config.php");
	$username = $_POST['username'];
	$password = $_POST['password'];

	$mess = $_POST['mess'];
	$name = $_POST['name'];

$_SESSION['tabadmin']=3;




	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$mess = stripcslashes($mess);
	$name = stripcslashes($name);




	$username = mysqli_real_escape_string($db,$username);
	$password = mysqli_real_escape_string($db,$password);

	$mess = mysqli_real_escape_string($db,$mess);
	$name = mysqli_real_escape_string($db,$name);



	$password = md5($password);







	// mysqli_connect("localhost","root","");
	// mysqli_select_db("mess_rating");

	
$result1 = mysqli_query($db,"SELECT * FROM mess_manager WHERE username = '$username' AND mess <> '$mess'") or die("Failed".mysqli_error($db));

	$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

	



	if ($row1['username'] == $username){

    $_SESSION['msg']="There already exist this username";
  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	exit();

	// you are in the wrong page 
	}

	else{



		if (mysqli_query($db, "UPDATE  mess_manager SET username = '$username', password = '$password', name = '$name' WHERE mess = '$mess'")) {
		    
    $_SESSION['msg']="Record Updated Successfully";
  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	exit();

		} 

	}

  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	exit();



	
	?>