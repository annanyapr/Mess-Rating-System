<?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    include("../config.php");
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

    $result = mysqli_query($db,"SELECT * FROM students WHERE username = '$rollno' ") or die("Failed".mysqli_error($db));
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $current_mess=$row['mess'];
    $next_mess=$row['next_mess'];
    $password=$row['password'];
    $name=$row['name'];
    $hostel = $row['hostel'];
    $msg='';
    if(isset($_SESSION['msg']))
    {
      $msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    $month = date("m");
    $year=date("Y");
    $result_feedback= mysqli_query($db,"SELECT * FROM feedback WHERE rollno = '$rollno' AND month = '$month' AND year = '$year' ") or die("Failed".mysqli_error($db));
    $feedbackrow = mysqli_fetch_array($result_feedback, MYSQLI_ASSOC);
    $feedback= $feedbackrow['text'];
    $tabindex=0;
    if(isset($_SESSION['tabstudent']))
    {
      $tabindex=$_SESSION['tabstudent'];
      unset($_SESSION['tabstudent']);
    }
    if(isset($_SESSION['month']))
    {
      $displaymonth=$_SESSION['month'];
      $displayyear=$_SESSION['year'];
    }
    else
    {
      $displaymonth=$month;
      $displayyear=$year;
    }


?>
<html>
<head>
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



<body onload="defaultload()"  >
  <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="../img/IITG-logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    IITG Mess Rating System
  </a>
     <span class="navbar-brand">Hello! <?php echo $name; ?></span>
 <span class="tab">
    <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Update')">Update Profile</button>
    <button class="tablinks" onclick="openTab(event, 'Feedback')">Feedback</button>
    <button class="tablinks" onclick="openTab(event, 'MessRatings')">Mess Ratings</button>
    <button class="tablinks" onclick="openTab(event, 'ChangePassword')">Change Password</button>
        <a href="../Report/report.php"><button>Report</button></a>
    <a href="../Login/logout.php"><button>Logout</button></a>

</nav>
      






  <div id="Update" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
          <h4><?php echo $msg; ?></h4>
        <div class="panel panel-default">
         <form method="POST" action="Update_Mess.php">
          <div class="form-group">
          <label for="studentname">Name </label>
          <input type="text" class="form-control" name="department" value="<?php echo $name; ?>"  readonly="true"/>
          </div>
   
          <div class="form-group">
          <label for="studentname">Roll NO </label>
          <input type="text" class="form-control"  value="<?php echo $rollno; ?>" readonly="true"/>
          </div>
   
          <div class="form-group">
          <label for="studentname">Hostel</label>
          <input type="text" class="form-control" value="<?php echo $hostel; ?>"  readonly="true"/>
          </div>
   
          <div class="form-group">
          <label for="studentname">Current Mess: </label>
          <input type="text" class="form-control" value="<?php echo $current_mess; ?>" readonly="true" />
          </div>
   
          <div class="form-group">
          <label for="studentregno">Mess for Next Month</label>
          <?php
            echo '<select class="form-control" name="mess">';
              $result = mysqli_query($db,"SELECT mess FROM  mess_manager ") or die("Failed".mysqli_error($db));
              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
              {
                if($row['mess']==$next_mess)
                {
                  echo '<option selected="selected" value="' . htmlspecialchars($row['mess']) . '">' . htmlspecialchars($row['mess']) 
                    . '</option>';
                }
                else
                {
                  echo '<option value="' . htmlspecialchars($row['mess']) . '">' . htmlspecialchars($row['mess']) 
                    . '</option>';
                }
              }
            echo '</select>';
          ?>
          </select>
      </div>
   
      <button class="btn btn-secondary btn-lg active"type="submit" name="mess_button" value="Yes" >Update</button>
      </form>
   
       </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>



  <div id="Feedback" class="tabcontent">
       <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
          <h4><?php echo $msg; ?></h4>
          <span class="border">
          <div class="card-header">
            Feedback For <?php echo date("F")." ".date("Y") ?>
          </div></span>
        <div class="panel panel-default">
         <form method="POST" action="Feedback_Submit.php">
          <div class="form-group">
          <label for="studentname"><br>Current Mess : </label>
          <input type="text" class="form-control" name="department" value="<?php echo $current_mess; ?>"  readonly="true"/>
          </div>
   
          <div class="form-group">
          <label for="studentname">Your Feedback </label>
          ​<textarea id="txtArea" class="form-control" rows="3" cols="70" name="feedback" required ><?php echo $feedback ?></textarea>
          <!-- <input type="text" class="form-control" name="feedback" placeholder='Your Feedback' value='<?php echo $feedback ?>' required>  -->
          </div>
   
   
      <button class="btn btn-secondary btn-lg active"type="submit" name="mess_button" value="Yes" >Update</button>
      </form>
   
       </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>






  <div id="MessRatings" class="tabcontent">
   <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
          <h4><?php echo $msg; ?></h4>
        <div class="panel panel-default">
         <form method="POST" action="Change_month.php" >
          <div class="form-group">
          <label for="studentname">Month </label>
          <input type="number" class="form-control" max="12" min="1" name="month" step="1" value="<?php echo $displaymonth;?>">
          </div>
   
          <div class="form-group">
          <label for="studentname">Year </label>
          <input type="number" class="form-control"   min="1" name="year" step="1" value="<?php echo $displayyear;?>">
          </div>
         <button class="btn btn-secondary btn-lg active"type="submit" name="Go" >Go</button>
          </form>
        </div>
      </div>
      <div style='padding: 30px 0px 0px 0px;'>
      <div class="card" style='padding: 30px 30px 30px 30px;' >
        <div class="panel panel-default">
          <div class="form-group">
          <h3>Mess Ratings </h3>
          <?php
            $all_messes=mysqli_query($db,"SELECT * FROM mess_manager ") or die("Failed".mysqli_error($db));
            while($mess_row=mysqli_fetch_array($all_messes, MYSQLI_ASSOC))
            {
              $cur_mess_rating=$mess_row['mess'];
              $mess_rating=0;
              $mess_count=0;
              $feedbacks_all=mysqli_query($db,"SELECT * FROM feedback WHERE month = '$displaymonth' AND year = '$displayyear' AND mess='$cur_mess_rating' ") or die("Failed".mysqli_error($db));
              while($row = mysqli_fetch_array($feedbacks_all, MYSQLI_ASSOC))
              {
                $review_total=0;
                $review_count=0;
                $words = preg_split("/[\s,_-]+/", strtolower($row['text']));
                foreach ($words as $w)
                {
                  $sqlstring="SELECT * FROM keyword WHERE word = '$w'";
                  $value_table=mysqli_query($db,$sqlstring);
                  while($wordrow = mysqli_fetch_array($value_table, MYSQLI_ASSOC))
                  {
                    $wordvalue=$wordrow['points'];
                    $review_total+=$wordvalue;
                    $review_count+=1;
                  }
                }
                if($review_count>0)
                {
                  $review_rating = $review_total/$review_count;
                  $mess_rating*=$mess_count;
                  $mess_count+=1;
                  $mess_rating+=$review_rating;
                  $mess_rating/=$mess_count;
                }

              }
              if($mess_count==0)
              {
                $mess_rating=5;
              }
              echo " <div style='padding: 5px 5px 5px 5px;'><div class='card' style='padding: 10px 10px 10px 10px;' ><h5>".
              $cur_mess_rating.":</h5>Rating:".$mess_rating."<br>Number of Reviews:".$mess_count."</div></div>";
            }
          ?>
          </div>   
       </div>
     </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>



  <div id="ChangePassword" class="tabcontent">
       <div class="row" style='padding: 50px 0px 0px 0px;'>
    <div class="col-3"></div>
      <div class="col">
        <div class="card" style='padding: 30px 30px 30px 30px;' >
          <h4><?php echo $msg; ?></h4>
        <div class="panel panel-default">
         <form method="POST" action="Password_Change.php" onsubmit="return validatepasswords()" name="passwordForm">
          <div class="form-group">
          <label for="studentname"><br>Old Password </label>
          <input type="password" class="form-control" name="old_password" required>
          </div>

          <div class="form-group">
          <label for="studentname"><br>New Password </label>
          <input type="password" class="form-control" name="new_password" required>
          </div>

          <div class="form-group">
          <label for="studentname"><br>Retype Password </label>
          <input type="password" class="form-control" name="re_password" required>
          </div>
   
   
      <button class="btn btn-secondary btn-lg active"type="submit" name="submit" >Change Password</button>
      </form>
   
       </div>
         </div>
       </div>
       <div class="col-3"></div>
       </div>
  </div>




  <script>
    function openTab(evt, TabName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(TabName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    function defaultload() {
            document.getElementsByClassName('tablinks')[<?php echo $tabindex ?>].click()
    }

    function validatepasswords() {
      var x = document.forms["passwordForm"]["new_password"].value;
      var y = document.forms["passwordForm"]["re_password"].value;
      if (x != y) {
        window.alert("Passwords Dont match");
        return false;
      }
      return true;
    }

  </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>