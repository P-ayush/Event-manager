<?php
/*
if session active then redirect to dashboard
if signup data-> validate data and insert into mysql
if signup is successfull then redirect to login page else show show error to users as signup failed and show signup form
if no signup data then show signup page 
*/
?>
<?php
session_start();
if(isset($_SESSION['user_id'])){
  header('location:dashboard.php');
}
?>
<html>
<body>
<h1 style=" text-align:center">SIGNUP</h1>  
<div class="container" style="text-align:center;color:black;padding:30px;">
<form action="signup.php" method="post">
<label for="email">E-mail:</label><br>
<input type="text" placeholder="Enter email" name="email"  required=""><br>
<label for="phone">Phone no.: </label><br>        
<input type="text" placeholder="Enter Phone no." name="phone"  required=""><br>
<label for="password">Password:</label><br>
<input type="text" placeholder="Enter Password" name="password"  required=""><br>
<label for="confirm password">Confirm Password:</label><br>
 <input type="text" placeholder="Re-enter Passsword" name="password"  required=""><br>

<input type="submit" name="signup">
</form>
</div>
<?php
if(isset($_POST)){
  if (!isset($_POST['email'], $_POST['password'], $_POST['phone'])) { 
	
    echo 'Please complete the signup!';
}else {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database="event_site";
  
  $conn = mysqli_connect($servername,
          $username, $password,$database);
          
 
  
  $sql="insert into users(email , password , phone_number) values(?,?,?)";
  $stmt=mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL error";
}else{
    mysqli_stmt_bind_param($stmt,"sss",$_POST['email'],$_POST['password'],$_POST['phone']);
  
    if (mysqli_stmt_execute($stmt)) {
      echo "New record created successfully";
    
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
 
  if(isset($_POST['signup'])){
    header('location:login.php');
  }
  mysqli_close($conn);
}
}
   

 
  
   
    ?>
    <a href="\Event-manager\login.php" target="_blank">Login</a>


</body>
</html>