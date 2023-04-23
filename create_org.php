<?php
/*
if session not active then redirect to login page
if post data then validate insert into mysql 

*/
?>
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
<h1 style="font-size:160%;text-align:center">Create Organisation</h1>
<form action="create_org.php" method="post">
<label for="name">Name:</label><br>
<input type="text" placeholder="Enter Name" name="name"  required=""><br>
<label for="address">Address: </label><br>        
<input type="text"  placeholder="Enter Address" name="address"  required=""><br>
<input type="submit" name="create_org" >
</form>
<?php
if(isset($_POST)){
    if (!isset($_POST['name'], $_POST['address'])) { 
	
        echo 'Please complete the organisation details!';
    }else{
 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    try{$conn = mysqli_connect($servername,
            $username, $password,$database);
            
    $sql="insert into organisation(name, address,user_id,status) values(?,?,?,'active')";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL error";
  }else{
      mysqli_stmt_bind_param($stmt,"sss",$_POST['name'],$_POST['address'],$_SESSION['user_id']);
      mysqli_stmt_execute($stmt);
  
      $result= mysqli_stmt_get_result($stmt);
    
  }
}catch(exception $ex){
    http_response_code(404);
    echo 'Something went wrong';
    exit();
}
    mysqli_close($conn); 
    if(isset($_POST['create_org'])){
        header('location:list-org.php');
            }
 }
}
    ?>

    </body> 
</html>