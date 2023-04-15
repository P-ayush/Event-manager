<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");

}
?>
<!doctype html>
<html>
<body>
<h1 style=" text-align:center">EVENTS</h1> 
<p style="font-size:180%">Create Event</P> 
<form action="create-event.php" method="post">
<label for="event_name">Event Name: </label><br>        
<input type="text" placeholder="Enter event name" name="event_name" required=""><br>
<label for="location">Location:</label><br>
<input type="text" placeholder="Enter Location" name="location" required=""><br>
<label for="start_time">Start Time:</label><br>
 <input type="text" placeholder="Enter start-time"name="start_time" required=""><br>
 <label for="end_time">End Time:</label><br>
 <input type="text" placeholder="Enter end-time" name="end_time" required=""><br>
 <label for="max_participants">Maximum Participants:</label><br>
 <input type="text" placeholder="Enter max participants" name="max_participants" required=""><br>
 <label for="reg_close">Registration Close:</label><br>
 <input type="text" name="reg_close" required=""><br>
<input type="submit" name ="create_event" >
</form> 

<?php
if(isset($_POST)){
    if (!isset($_POST['event_name'], $_POST['location'], $_POST['start_time'],$_POST['end_time'], $_POST['max_participants'], $_POST['reg_close'])) { 
	
        echo 'Please complete the event details!';
    }else{

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            
   
    
    $sql="insert into event(event_name,location,start_time,end_time,maximum_participants,registration_close,user_id,status) values(?,?,?,?,?,?,?,'active')";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL error";
  }else{
      mysqli_stmt_bind_param($stmt,"sssssss",$_POST['event_name'],$_POST['location'],$_POST['start_time'],$_POST['end_time'],$_POST['max_participants'],$_POST['reg_close'],$_SESSION['user_id']);
      mysqli_stmt_execute($stmt);
      $result= mysqli_stmt_get_result($stmt);
    
  }
  mysqli_close($conn);
    if(isset($_POST['create_event'])){
        header('location:list-event-org_id.php');
    }
}

}

    ?>
</body> 
</html>