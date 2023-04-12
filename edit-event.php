<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    
    header("Location: login.php");

}
?>
<html>
    <body>

<?php echo '<form action="edit-event.php?event_id='.$_GET['event_id'].'"'?> method="post">
<label for="event_name">Event Name: </label><br>        
<input type="text" placeholder="Enter new event name" name="event_name" required=""><br>
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



<input type="submit" name="submit" value="edit">
</form>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database="event_site";

// Connection
$conn = mysqli_connect($servername,
        $username, $password,$database);
        

if(isset($_POST)){
    if(isset($_POST['submit'])){

  $update="update event set event_name=?,location=?,start_time=?,end_time=?,maximum_participants=?,registration_close=? where event_id=?";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$update)){
    echo "SQL error";
}else{
    mysqli_stmt_bind_param($stmt,"sssssss",$_POST['event_name'],$_POST['location'],$_POST['start_time'],$_POST['end_time'],$_POST['max_participants'],$_POST['reg_close'],$_GET['event_id']);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);
  
}
  
  
  header('location:list-event-org_id.php');
  mysqli_close($conn);
}
}
?>
</body>
</html>