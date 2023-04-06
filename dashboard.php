<?php
/*
if no session then redirect to login page

*/
?>
<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    echo 'no session';
    header("Location: login.php");

}
?>
<!doctype html>
<html>
<body>
<h1 style=" text-align:center">DASHBOARD</h1>  
<!--<button onclick="document.location='create_org.php'">Create Organisation</button>!-->
<!--<button onclick="document.location='create-event.php'">Create Event</button>!-->
<button onclick="document.location='list-org.php'">Organisation</button>
<button onclick="document.location='logout.php'">Logout</button>
<h2>Event</h2>
<?php
  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    // Connection
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            

    $sql="select * from event where user_id=" .$_SESSION['user_id'];
  
    $result=mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo"<table>
        <tr>
          <th>Event ID</th>
          <th>Event Name</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Location</th>
          <th>Maximum Participants</th>
          <th>Registration Close</th>
          <th>Add Participants</th>";

        while($row = mysqli_fetch_assoc($result)) {
        
  
  echo"</tr>
  <tr>
    <td> <a href=invite-participants.php?event_id=".$row['event_id']."> ".$row['event_id'] ."</a></td>
    <td>".$row['event_name']."</td>
    <td>".$row['start_time']."</td>
    <td>".$row['end_time']."</td>
    <td>".$row['location']."</td>
    <td>".$row['maximum_participants']."</td>
    <td>".$row['registration_close']."</td>
    
  </tr>";
  


        }
      echo "</table>";
      } else {
        echo "0 results";
      }
      


mysqli_close($conn);

?>

</body> 
</html>