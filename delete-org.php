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
    $delete="update organisation set status='deleted' where organisation_id=".$_GET['org_id']. " and user_id=".$_SESSION['user_id'];
   
     mysqli_query($conn,$delete);
   
    header('location:list-org.php');
    mysqli_close($conn);
       }
       if(isset($_POST['no'])){
        header('location:list-org.php');
       }
      }
    }catch(exception $ex){
        http_response_code(404);
        echo 'Unable to delete';
        exit();
    }
?>
</body>
</html> 