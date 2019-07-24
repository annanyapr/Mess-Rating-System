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
include("func.php");
include("config.php");

$_SESSION['tabadmin']=5;












  mysqli_query($db,"DELETE FROM reports") or die("Failed".mysqli_error($db));


  $result2 = mysqli_query($db,"SELECT * FROM mess_manager") or die("Failed".mysqli_error($db));


  while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {

    $mess = $row['mess'];
    $result3=mysqli_query($db, "SELECT count(*) as total from students WHERE mess = '$mess'");
    $old_subscribers = mysqli_fetch_array($result3, MYSQLI_ASSOC)['total'];

    $result3=mysqli_query($db, "SELECT count(*) as total from students WHERE next_mess = '$mess'");
    $new_subscribers= mysqli_fetch_array( $result3, MYSQLI_ASSOC)['total'];




$day = date("d");
$month = date("m");
$year=date("Y");
    


    $month1 = ($month+11)%12;
    $year1 = $year;
    if ($month == 1){
      $year1 = $year -1;
    }


    $mess_rating_current = rating($mess, $year1, $month1,$db)[0];

    if($old_subscribers == 0) {
   $feedback_participation =  0;
    }
    else{
	    $feedback_participation = rating($mess, $year1, $month1,$db)[1]/ $old_subscribers * 100; 

}
    $month2 = ($month + 10)%12;

    $year2 = $year;

    
    if ($month2 <= 2){
      $year2 = $year -1;
    }


     $mess_rating_old = rating($mess, $year2, $month2, $db)[0];




    mysqli_query($db, "INSERT INTO reports (mess, old_subscribers, new_subscribers, avg_rating_old, avg_rating_current, feedback_participation)
    VALUES ('$mess', '$old_subscribers', '$new_subscribers', '$mess_rating_old', '$mess_rating_current', '$feedback_participation')");




  }



mysqli_query($db, "UPDATE  students SET mess = next_mess");



    $_SESSION['msg']="Mess Changed Successfully";
  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
	exit();


	
	?>