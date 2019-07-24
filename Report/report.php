<?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // if(isset($_SESSION['type']))
    // {
    //   if($_SESSION['type']=='students')
    //   {
    //     header("Location: http://{$_SERVER['HTTP_HOST']}/Student/home.php");
    //     exit();
    //   }
    //   else if ($_SESSION['type']=='admin')
    //   {
    //     header("Location: http://{$_SERVER['HTTP_HOST']}/Admin/admin.php");
    //     exit();
    //   }
    //
    // }
    //
    // $username=$_SESSION['user'];
    //
    // $result = mysqli_query($db,"SELECT * FROM mess_manager WHERE username = '$username' ") or die("Failed".mysqli_error($db));
    //

?>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
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
  border: 1px solid #ccc;
  border-top: none;
}


body {
  background: url(../images/slide3.jpg) no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}


</style>

<body  >

  <div class="row" style='padding: 50px 0px 0px 0px;'>
   <div class="col-3"></div>
     <div class="col">
       <div class="card" style='padding: 30px 30px 30px 30px;' >

             <h2>Mess Report for
              <?php echo date('F')." ".date('Y');?></h2>
             <table class="table">
               <thead>
                 <tr>
                   <th>Mess</th>

                   <th>Rating(Last Month)</th>
                   <th>Rating(Last to Last Month)</th>
                   <th>Subscriber Count(Last Month )</th>
                   <th>Subscriber Count(Current)</th>
                   <th>Feedback Participtaion(in %)</th>


                 </tr>
               </thead>
               <tbody>

                 <?php
                 include("../config.php");
                 $result = mysqli_query($db,"SELECT * FROM reports ORDER BY avg_rating_current DESC") or die("Failed".mysqli_error($db));
                 $contracts = array();

                 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                   if ($row['avg_rating_current'] < 2.5 ){
                     echo '<tr class="Danger">';

                     array_push($contracts, $row['mess']);


                   }

                   else{
                     echo '<tr class="Success">';
                   }

                   echo '<td>'.htmlspecialchars($row['mess']).'</td>'
                         .'<td>'.htmlspecialchars($row['avg_rating_current']).'</td>'
                         .'<td>'.htmlspecialchars($row['avg_rating_old']).'</td>'
                         .'<td>'.htmlspecialchars($row['old_subscribers']).'</td>'
                         .'<td>'.htmlspecialchars($row['new_subscribers']).'</td>'
                         .'<td>'.htmlspecialchars($row['feedback_participation']).'</td>';
                   echo '</tr>';





                 }
                  ?>

               </tbody>
             </table>






        </div>
        <div class='card'>
        <div class="card-header"><h3>Comments</h3></div>
        <div class="card-body" style='padding: 30px 30px 30px 30px;'>
          <?php

          if (count($contracts) == 0){
            echo '<b>All the messes have ratings above the required threshold. This shows an overall positive outlook towards the IIT Guwahati Catering System</b>';

          }
          else{
            for ($i = 0; $i < count($contracts); $i++){
              echo '<b>'.htmlspecialchars($contracts[$i]).'</b>,';
            }
            echo 'have been given show cause notices for their bad food quality. They have been asked to immediately improve their food quality or will face further actions which might involve termination of their services. ';


          }


           ?>

        </div>


        </div>
      </div>
      <div class="col-3"></div>
      </div>


     </body>
</html>
