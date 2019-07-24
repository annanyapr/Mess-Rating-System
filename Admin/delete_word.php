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
	
	$word = $_POST['delete'] ;


$_SESSION['tabadmin']=4;


	mysqli_query($db,"DELETE FROM keyword WHERE word = '$word'") or die("Failed".mysqli_error($db));


    $_SESSION['msg']="Deleted Successfully";
  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	exit();


	
	?>