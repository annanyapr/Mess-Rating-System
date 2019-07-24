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

	
$_SESSION['tabadmin']=0;


	// $hostel = $_POST['hostel'];


	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$mess = stripcslashes($mess);
	$name = stripcslashes($name);

	// $hostel = stripcslashes($hostel);



	$username = mysqli_real_escape_string($db,$username);
	$password = mysqli_real_escape_string($db,$password);

	$mess = mysqli_real_escape_string($db,$mess);
	$name = mysqli_real_escape_string($db,$name);
	// $hostel = mysqli_real_escape_string($db,$hostel);




	$password = md5($password);

	$result = mysqli_query($db,"SELECT * FROM students WHERE username = '$username'") or die("Failed".mysqli_error($db));

	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);




	if ($row['username'] == $username){

				 $_SESSION['msg']="There exists a user already with this Roll Number";


  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
  exit();

	}

	else{



		if (mysqli_query($db, "INSERT INTO students (username, password, mess, next_mess, hostel, name)
VALUES ('$username', '$password', '$mess', '$mess', '$mess', '$name')")) {
		    

					 $_SESSION['msg']="New user created successfully";


  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
  exit();

	}




	}

  header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
  exit();

	

	
	?>