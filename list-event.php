
<?php
/*
add user id instead of email in event table
*/
session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");

}
?>
<html>
<body>
    


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
          <th>Registration Close</th>";
          

        while($row = mysqli_fetch_assoc($result)) {
        
  
  echo"</tr>
  <tr>
    <td> ".$row['event_id'] ."</td>
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
<button onclick="document.location='invite-participants.php'">Invite Participants</button>
</body>
</html>