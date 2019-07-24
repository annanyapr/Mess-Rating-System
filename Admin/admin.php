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
  include("func.php");


    $msg="";
    if(isset($_SESSION['msg']))
    {
      $msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    }


    $tabindex=0;
    if(isset($_SESSION['tabadmin']))
    {
      $tabindex=$_SESSION['tabadmin'];
      unset($_SESSION['tabadmin']);
    }


?>


<?php

$day = date("d");
$month = date("m");
$year=date("Y");
    
// HERE YOU CAN 
  
$result1 = mysqli_query($db,"SELECT * FROM run WHERE ind = 1 ") or die("Failed".mysqli_error($db));





if ($day == 1){
  if (mysqli_fetch_array($result1, MYSQLI_ASSOC)['run'] == 0){
    



  mysqli_query($db,"DELETE FROM reports") or die("Failed".mysqli_error($db));


  $result2 = mysqli_query($db,"SELECT * FROM mess_manager") or die("Failed".mysqli_error($db));


  while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {

    $mess = $row['mess'];
    $result3=mysqli_query("SELECT count(*) as total from students WHERE mess = '$mess'");
    $old_subscribers = mysqli_fetch_arra($db,$result3)['total'];

    $result3=mysqli_query("SELECT count(*) as total from students WHERE next_mess = '$mess'");
    $new_subscribers= mysqli_fetch_arra($db,$result3)['total'];






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

    mysqli_query($db, "UPDATE  run SET run = 1 WHERE ind = 1");
  }

}
else{

    mysqli_query($db, "UPDATE  run SET run = 0 WHERE ind = 1");
}



?>




<html>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
body { 
  background: url(../images/slide3.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

body {font-family: "Comic Sans MS", cursive, sans-serif;}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #7F8188;
  background-color: #7F8188;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: none;
  border-top: none;
}
</style>


<body onload="defaultload()">

   <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
    <img src="../img/IITG-logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    IITG Mess Rating System
  </a>
     <span class="navbar-brand">Hello! Admin</span>

 <span class="tab">
    <button class="tablinks" onclick="openCity(event, 'London')">Add User</button>
    <button class="tablinks" onclick="openCity(event, 'Paris')">Remove User</button>
    <button class="tablinks" onclick="openCity(event, 'Tokyo')">Add Mess</button>
    <button class="tablinks" onclick="openCity(event, 'Delhi')">Update Mess</button>
    <button class="tablinks" onclick="openCity(event, 'Mumbai')">Key Words</button>
    <button class="tablinks" onclick="openCity(event, 'Guwahati')">Update</button>
    <a href="../Report/report.php"><button>Report</button></a>
    <a href="../Login/logout.php"><button>Logout</button></a>
  </span>
</nav>

<div class="tab">

  
</div>





<!-- Tab contents -->

  <div id="London" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>
                    <span class="border">
          <div class="card-header">
            <h3>Add User</h3> </div></span>

        <div class="panel panel-default">
          <br>
            <form method="POST" action="add_user.php">
          <div class="form-group">
          <label for="studentname">Name </label>
          <input type="text" class="form-control" name="name" placeholder="Name" required>
          </div>
   
          <div class="form-group">
          <label for="studentname">Mess</label>
          
            <?php

            echo '<select class="form-control" name="mess">';
              $result = mysqli_query($db,"SELECT mess FROM  mess_manager ") or die("Failed".mysqli_error($db));

              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
              {
                echo '<option value="' . htmlspecialchars($row['mess']) . '">' 
                    . htmlspecialchars($row['mess']) 
                    . '</option>';
              }
              
            echo '</select>';

            ?>
          </div>
   
          <div class="form-group">
          <label for="studentname">Roll No</label>
          <input type="number" class="form-control" name="username" step="1"  min="100000000" max="999999999" maxlength="9" placeholder="Roll No" required>
          </div>
           <div class="form-group">
          <label for="studentname">Password</label>
          <input type="password" class="form-control"  name="password"  placeholder="Password" required>
          </div>
              <button class="btn btn-secondary btn-lg active" type="submit" name="submit" >Create User</button>
  </form>
   
          </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>

<!-- This is the place to remove user -->





<div id="Paris" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>
                    <span class="border">
          <div class="card-header">
            <h3>Remove User</h3> </div></span>

        <div class="panel panel-default">
          <br>
            <form method="POST" action="remove_user.php">
          <div class="form-group">
          <label for="studentname">Roll No. </label>
          <input type="number" class="form-control" name="username" step="1"  min="100000000" max="999999999" maxlength="9" placeholder="Roll No" required>
          </div>
              <button class="btn btn-secondary btn-lg active" type="submit" name="remove" >Remove User</button>
            </form>
   
          </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>






<div id="Tokyo" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>
                    <span class="border">
          <div class="card-header">
            <h3>Add Mess</h3> </div></span>

        <div class="panel panel-default">
          <br>
    <form method="POST" action="add_mess.php">
          <div class="form-group">
          <label for="studentname">Caterer's Name </label>
          <input type="text" class="form-control" name="name" placeholder="Caterer's Name" required>
          </div>
          <div class="form-group">
          <label for="studentname">Mess Name </label>
          <input type="text" class="form-control" name="mess" placeholder="Mess Name" required>
          </div>
          <div class="form-group">
          <label for="studentname">Username </label>
          <input type="text" class="form-control" name="username"  placeholder="Username" required>
          </div>
   
           <div class="form-group">
          <label for="studentname">Password</label>
          <input type="password" class="form-control"  name="password"  placeholder="Password" required>
          </div>
              <button class="btn btn-secondary btn-lg active" type="submit" name="add_mess" >Add Mess</button>
  </form>
   
          </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>













<div id="Delhi" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>
                    <span class="border">
          <div class="card-header">
            <h3>Update Mess</h3> </div></span>

        <div class="panel panel-default">
          <br>

    <form method="POST" action="update_mess.php">
          <div class="form-group">
          <label for="studentname">Mess </label>
            <?php


            echo '<select class="form-control" name="mess">';
              $result = mysqli_query($db,"SELECT mess FROM  mess_manager ") or die("Failed".mysqli_error($db));

              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
              {
                echo '<option value="' . htmlspecialchars($row['mess']) . '">' 
                    . htmlspecialchars($row['mess']) 
                    . '</option>';
              }
              
            echo '</select>';

            ?>
          </div>
          <div class="form-group">
          <label for="studentname">Caterer's Name </label>
          <input type="text" class="form-control" name="name" placeholder="Caterer's Name" required>
          </div>
          <div class="form-group">
          <label for="studentname">New Username </label>
          <input type="text" class="form-control" name="username"  placeholder="Username" required>
          </div>
   
           <div class="form-group">
          <label for="studentname">New Password</label>
          <input type="password" class="form-control"  name="password"  placeholder="Password" required>
          </div>
              <button class="btn btn-secondary btn-lg active" type="submit" name="update_mess" >Update Mess</button>
  </form>
   
          </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>










<div id="Mumbai" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-4"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>
                    <span class="border">
          <div class="card-header">
            <h3>Key Words</h3> </div></span>

        <div class="panel panel-default">
          <br>


  <form method="POST" action="add_word.php">



          <div class="form-group">
          <label for="studentname">Word </label>
          <input type="text" class="form-control" name="word" placeholder="Word" required>
          </div>
          <div class="form-group">
          <label for="studentname">Value </label>
          <input type="number" class="form-control" name="points" step="1" min="0" max="10"  placeholder="0" required>
          </div>

          <button class="btn btn-secondary btn-lg active" type="submit" name="add_word" >Add Word</button>







  </form>


<div>



    <table class="table">
               <thead>
                 <tr>
                   <th>Word</th>

                   <th>Score</th>
                   <th></th>
                 

                 </tr>
               </thead>
               <tbody>


    <?php


    
      $result = mysqli_query($db,"SELECT * FROM  keyword ") or die("Failed".mysqli_error($db));


      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
      {
echo '<form method=POST action="delete_word.php'.'">';
                     echo '<tr >';

                   echo '<td>'.htmlspecialchars($row['word']).'</td>'
                         .'<td>'.htmlspecialchars($row['points']).'</td>'
                         .'<td>'.'<button class="btn btn-danger" type="submit" name="delete"'.' value='.htmlspecialchars($row['word']).'>Delete Word</button>'.'</td>';
                         
                   echo '</tr>';
                  echo '</form>';
      }


      
      
    echo '</select>';

    ?>
   
</tbody>
</table>

</div>

</div>
   
</div>
 </div>
 
 <div class="col-4"></div>
 </div>
 </div>
















<div id="Mumbai" class="tabcontent">
	<h3>Key Words</h3>
	<form method="POST" action="add_word.php">


		<div >

		    <label>Word</label>
		    <input type="text" name="word"  placeholder="Word" required>
		    <label>Value</label>
		    <input type="number" name="points" step="1" min="0" max="10" placeholder="0" required>
		  <button type="submit" name="add" >Add Word</button>
	

		 </div>

	</form>






    <table class="table">
               <thead>
                 <tr>
                   <th>Word</th>

                   <th>Score</th>
                   <th></th>
                 

                 </tr>
               </thead>
               <tbody>


	  <?php


		
			$result = mysqli_query($db,"SELECT * FROM  keyword ") or die("Failed".mysqli_error($db));


			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
			{
echo '<form method=POST action="delete_word.php'.'">';
                     echo '<tr >';

                   echo '<td>'.htmlspecialchars($row['word']).'</td>'
                         .'<td>'.htmlspecialchars($row['points']).'</td>'
                         .'<td>'.'<button type="submit" name="delete"'.' value='.htmlspecialchars($row['word']).'>Delete Word</button>'.'</td>';
                         
                   echo '</tr>';
                  echo '</form>';
			}


			
			
		echo '</select>';

	  ?>
   
</tbody>
</table>










</div>






<div id="Guwahati" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card text-center" style='padding: 30px 30px 30px 30px;' >
                    <h4><?php echo $msg; ?></h4>

        <div class="panel panel-default">
          <br>
           <form method="POST" action="update.php">
              <button class="btn btn-secondary btn-lg active" type="submit" name="update" >Update</button>
            </form>
   
          </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>



</body>








<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

 function defaultload() {
            document.getElementsByClassName('tablinks')[<?php echo $tabindex ?>].click()
        }
</script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
