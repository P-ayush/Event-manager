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
try{$conn = mysqli_connect($servername,
        $username, $password,$database);

$sql="select name, address from organisation where organisation_id=".$_GET['org_id'];
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

<?php echo '<form action="edit-org.php?org_id='.$_GET['org_id'].'"'?> method="post">
<label for="name">New Name:</label><br>
<input type="text" name="name" value="<?php echo $row['name']?>"><br>
<label for="address">Address:</label><br>
<input type="text" name="address" value="<?php echo $row['address']?>"><br>


<input type="submit" name="submit" value="edit">
</form>
<?php


if(isset($_POST)){
    if(isset($_POST['submit'])){
      $sql1="select name from organisation where status ='active' and name=? and user_id=?";  //per user
      $stmt1=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt1,$sql1)){
          echo "SQL error";
          http_response_code(500);
      }else{
          mysqli_stmt_bind_param($stmt1,"ss",$_POST['name'],$_SESSION['user_id']);
          mysqli_stmt_execute($stmt1);
         
          $result1= mysqli_stmt_get_result($stmt1);
         
      }
      // echo $sql1;
      // $result1=mysqli_query($conn,$sql1);
      $row = mysqli_fetch_assoc($result1);
      $name=$_POST['name'];
      $address=$_POST['address'];
      if($_POST['name']== $row['name']){
        http_response_code(400);//duplicate entry
        
    $err="This name already used, use another ";
  
     }
     if(empty($err)){
  $update="update organisation set name=?,address=? where organisation_id=?";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$update)){
    echo "SQL error";
    http_response_code(500);
}else{
  try{  mysqli_stmt_bind_param($stmt,"sss",$_POST['name'],$_POST['address'],$_GET['org_id']);
    mysqli_stmt_execute($stmt);
    $result= mysqli_stmt_get_result($stmt);
  }catch(exception $ex){
    http_response_code(500);
    echo 'unable to edit';
    exit();
  }
}
}
  if(empty($err)){
  header('location:list-org.php');
  }else{
    echo $err;
  }
  mysqli_close($conn);
}
}
?>
</body>
</html>