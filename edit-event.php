<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    
    header("Location: login.php");

}
$servername = "localhost";
$username = "root";
$password = "";
$database="event_site";

// Connection
try{$conn = mysqli_connect($servername,
        $username, $password,$database);

$sql="select * from event where event_id=".$_GET['event_id'];
$result=mysqli_query($conn,$sql);
}catch(exception $ex){
  http_response_code(500);
  echo 'something went wrong';
  exit();
}
$row = mysqli_fetch_assoc($result);
?>
<html>
    <body>

<?php echo '<form action="edit-event.php?event_id='.$_GET['event_id'].'"'?> method="post">
<label for="event_name">Event Name: </label><br>        
<input type="text" placeholder="Enter new event name" name="event_name" value="<?php echo $row['event_name']?>" required=""><br>
<label for="location">Location:</label><br>
<input type="text" placeholder="Enter Location" name="location" value="<?php echo $row['location']?>" required=""><br>
<label for="start_time">Start Time:</label><br>
 <input type="text" placeholder="Enter start-time"name="start_time" value="<?php echo $row['start_time']?>" required=""><br>
 <label for="end_time">End Time:</label><br>
 <input type="text" placeholder="Enter end-time" name="end_time" value="<?php echo $row['end_time']?>" required=""><br>
 <label for="max_participants">Maximum Participants:</label><br>
 <input type="text" placeholder="Enter max participants" name="max_participants" value="<?php echo $row['maximum_participants']?>" required=""><br>
 <label for="reg_close">Registration Close:</label><br>
 <input type="text" name="reg_close" value="<?php echo $row['registration_close']?>" required=""><br>



<input type="submit" name="submit" value="edit">
</form>
<?php

        

if(isset($_POST)){
    if(isset($_POST['submit'])){
      $sql1="select event_name from event  where status ='active' and event_name=? and user_id=?";  //per user
      $stmt1=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt1,$sql1)){
          echo "SQL error";
          http_response_code(500);
      }else{
          mysqli_stmt_bind_param($stmt1,"ss",$_POST['event_name'],$_SESSION['user_id']);
          mysqli_stmt_execute($stmt1);
         
          $result1= mysqli_stmt_get_result($stmt1);
         
      }
      // echo $sql1;
      // $result1=mysqli_query($conn,$sql1);
      $row = mysqli_fetch_assoc($result1);
     
     
      if($_POST['event_name']== $row['event_name']){
        http_response_code(400);//duplicate entry
        
    $err="This name already used, use another ";
  
     }
     if(empty($err)){
  $update="update event set event_name=?,location=?,start_time=?,end_time=?,maximum_participants=?,registration_close=? where event_id=?";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$update)){
    echo "SQL error";
    http_response_code(500);
}else{
 try{   mysqli_stmt_bind_param($stmt,"sssssss",$_POST['event_name'],$_POST['location'],$_POST['start_time'],$_POST['end_time'],$_POST['max_participants'],$_POST['reg_close'],$_GET['event_id']);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);
 }catch(exception $ex){
  http_response_code(500);
  echo 'unable to edit';
  exit();
 }
  
}

  
  header('location:list-event-org_id.php');
  mysqli_close($conn);
}else{
  echo $err;

}
}
}
?>
</body>
</html>