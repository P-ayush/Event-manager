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
$name=$address="";
?>
<!doctype html>
<html>
<body>
<h1 style="font-size:160%;text-align:center">Create Organisation</h1>
<form action="create_org.php" method="post">
<label for="name">Name:</label><br>
<input type="text" placeholder="Enter Name" name="name" value= '<?php if(!empty($_POST['address'])){echo $_POST['name'];}else{echo $name;} ?>' required=""><br>
<label for="address">Address: </label><br>        
<input type="text"  placeholder="Enter Address" name="address" value= '<?php if(!empty($_POST['address'])){echo $_POST['address'];}else{echo $address;} ?>' required=""><br>
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
    
    try{
      $conn = mysqli_connect($servername,
            $username, $password,$database);

        $sql1="select name from organisation where status ='active' and name='".$_POST['name']."'";  
        $result1=mysqli_query($conn,$sql1);
        $row = mysqli_fetch_assoc($result1);
        $name=$_POST['name'];
        $address=$_POST['address'];
        if($_POST['name']== $row['name']){
          http_response_code(400);//duplicate entry
          
      $err="This name already used, use another ";
    
       }
       
       if(empty($err)){
    $sql="insert into organisation(name, address,user_id,status) values(?,?,?,'active')";
    $stmt=mysqli_stmt_init($conn);
       
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL error";
      http_response_code(500);
  }else{
      mysqli_stmt_bind_param($stmt,"sss",$_POST['name'],$_POST['address'],$_SESSION['user_id']);
      mysqli_stmt_execute($stmt);
  
      $result= mysqli_stmt_get_result($stmt);
    
  }
}
}catch(exception $ex){
    http_response_code(500);
    echo 'Something went wrong.
    try again';
    // echo '<form action="create_org.php" method="post">
    // <label for="name">Name:</label><br>
    // <input type="text" placeholder="Enter Name" name="name" value='.$_POST['name'].' required=""><br>
    // <label for="address">Address: </label><br>        
    // <input type="text"  placeholder="Enter Address" name="address" value='.$_POST['address'].'  required=""><br>
    // <input type="submit" name="create_org" >
    // </form>';
    exit();
}
mysqli_close($conn); 
    if(isset($_POST['create_org']) AND empty($err)){
         header('location:list-org.php');
            }else{
              echo $err;
            }
           
 }
 
}

    ?>

    </body> 
</html>