<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    
    header("Location: login.php");

}
?>
<html>
    <body>

   <form method="post">
   <p> Are you sure</p>
  <input type="submit"  name="yes" value="yes">
  <input type="submit"  name="no" value="no">
</form>
<!--<form method="post">
<input type="button" name="button" onclick="alert('Are you sure?')" value="yes">
</form>!-->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database="event_site";

// Connection
try{$conn = mysqli_connect($servername,
        $username, $password,$database);
       if(isset($_POST)) {
if(isset($_POST['yes'])){
    /*$delete="delete from event where event_id=".$_GET['event_id'];*/
    $delete="update event set status='deleted' where event_id=".$_GET['event_id']." and user_id=".$_SESSION['user_id'];
   
    mysqli_query($conn, $delete);
    header('location:list-event-org_id.php?event_id='.$_GET['event_id']);
    mysqli_close($conn);
       }
       
       if(isset($_POST['no'])){
        header('location:list-event-org_id.php?event_id='.$_GET['event_id']);
       }
      }
    }catch(exception $ex){
        http_response_code(500);
        echo 'Unable to delete';
        exit();
    }
?>
</body>
</html> 