
<?php
/*
add user id instead of email in event table
*/
session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");

}
/*if(isset($_GET['event_id']) OR isset($_GET['org_id'])){
  header("Location: list-event-org_id.php");
}*/
if(!isset($_GET['org_id'])){
header('location:list-org.php');
}

?>
<html>
<body>
    
<button onclick="document.location='create-event.php'">Create Event</button>

<?php
  
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    // Connection
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            
$sql="select event.event_name, event.start_time, event.end_time,event.location,event.maximum_participants,event.registration_close,event.event_id,event.user_id,organisation.organisation_id from event inner join organisation on event.user_id=organisation.user_id where event.user_id=".$_SESSION['user_id'];
   /* $sql="select * from event where user_id=" .$_SESSION['user_id'];*/
  
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
    <td><a href =edit-event.php?event_id=".$row['event_id'].">Edit</a></td>
    <td><a href =delete-event.php?event_id=".$row['event_id'].">Delete</a></td>
  </tr>";
  


        }
      echo "</table>";
      } else {
        echo "0 results";
      }
      


mysqli_close($conn);

?>
<button onclick="document.location='invite-participants.php'">Invite Participants</button>
</body>
</html>