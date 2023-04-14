<?php
session_start();

if(!isset($_SESSION['user_id']))
{
    
    header("Location: login.php");

}
if(!isset($_GET['org_id'])){
  header('location:list-org.php');
}
$servername = "localhost";
$username = "root";
$password = "";
$database="event_site";

// Connection
$conn = mysqli_connect($servername,
        $username, $password,$database);

$sql="select name, address from organisation where organisation_id=".$_GET['org_id'];
$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
        
    

?>
<html>
    <body>

<?php echo '<form action="edit-org.php?org_id='.$_GET['org_id'].'"'?> method="post">
<label for="name">New Name:</label><br>
<input type="text" name="name" value="<?php echo $row['name']?>"><br>
<label for="address">Address:</label><br>
<input type="text" name="address" value="<?php echo $row['address']?>"><br>


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

  $update="update organisation set name=?,address=? where organisation_id=?";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$update)){
    echo "SQL error";
}else{
    mysqli_stmt_bind_param($stmt,"sss",$_POST['name'],$_POST['address'],$_GET['org_id']);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);
  
}
 
  
  header('location:list-org.php');
  mysqli_close($conn);
}
}
?>
</body>
</html>