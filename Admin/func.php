<?php 
 

//include("config.php");
function rating($mess, $year, $month,$db){

   // define('DB_SERVER', 'localhost');
   // define('DB_USERNAME', 'root');
   // define('DB_PASSWORD', '');
   // define('DB_DATABASE', 'mess_rating');
   // $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);





      $cur_mess_rating=$mess;
        $mess_rating=0;
        $mess_count=0;
        $feedbacks_all=mysqli_query($db,"SELECT * FROM feedback WHERE month = '$month' AND year = '$year' AND mess='$cur_mess_rating' ") or die("Failed".mysqli_error($db));
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
            $result3=mysqli_query($db, "SELECT count(*) as total from feedback WHERE mess = '$mess' AND year='$year' AND month='$month' ");
    $total_feedbacks = mysqli_fetch_array($result3, MYSQLI_ASSOC)['total'];
        return array($mess_rating, $total_feedbacks);







}


 ?>