<?php
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
            

    $sql="select * from organisation where user_id=".$_SESSION['user_id'];
  
    $result=mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo"<table>
        <tr>
          <th>User ID</th>
          <th>Organisation ID</th>
          <th>Name</th>
          <th>Address</th>";
          

        while($row = mysqli_fetch_assoc($result)) {
        
  
  echo"</tr>
  <tr>
    <td> ".$row['user_id'] ."</td>
    <td>".$row['organisation_id']."</td>
    <td>".$row['name']."</td>
    <td>".$row['address']."</td>
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