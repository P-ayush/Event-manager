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
$emailErr = $phoneErr = $passwordErr ="";  
$email = $phone = $password= "";  
if(isset($_POST)){

//Email Validation   
if (!empty($_POST["email"])) {  
   
     $email =input_data($_POST["email"]);  
     // check that the e-mail address is well-formed  
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
         $emailErr = "Invalid email format";  
     }  
}  

//Number Validation  
if (!empty($_POST["phone"])) {  
      
     $phone = input_data($_POST["phone"]);  
     // check if mobile no is well-formed  
     if (!preg_match('/^[0-9]*$/', $phone) ) {  
     $phoneErr = "Only numeric value is allowed.";  
     }  
 //check mobile no length should not be less and greator than 10  
 if (strlen($phone) != 10) {  
     $phoneErr = "Mobile no must contain 10 digits.";  
     }  
} 

if(!empty($_POST['password'])){

  $password=$_POST['password'];
// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
  $passwordErr= 'Password should be at least 8 characters and max 10 in length and should include at least one upper case letter, one number, and one special character.';
}else{
    echo 'Strong password.';
}
}

}
function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
  
}  
?>
<html>
<body>
<h1 style=" text-align:center">SIGNUP</h1>  
<div class="container" style="text-align:center;color:black;padding:30px;">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label for="email">E-mail:</label><br>
<input type="text" placeholder="Enter email" name="email" value= '<?php echo $email ?>' required=""> <span class="error">* <?php echo $emailErr;?></span><br>  

<label for="phone">Phone no.: </label><br>        
<input type="text" placeholder="Enter Phone no." name="phone" value= '<?php echo $phone ?>' required=""><span class="error">* <?php echo $phoneErr;?></span><br> 
<label for="password">Password:</label><br>
<input type="text" placeholder="Enter Password" name="password"  required=""><span class="error">* <?php echo $passwordErr;?></span><br>
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
  
 try{ $conn = mysqli_connect($servername,
          $username, $password,$database);
          
          if(empty($emailErr) AND empty($phoneErr) AND empty($passwordErr) ){
            
  $sql1="select * from users where email ='".$_POST['email']."' or phone_number= ". $_POST['phone'];
  // echo $sql1;
  $result=mysqli_query($conn,$sql1);
  $row = mysqli_fetch_assoc($result);

  if($_POST['email']==$row['email'] OR $_POST['phone']==$row['phone_number']){
    http_response_code(400);//duplicate entry
    
$entryerr="email or phone already used, use another ";
 }
 if(empty($entryerr)){
  $sql="insert into users(email , password , phone_number) values(?,?,?)";
  $stmt=mysqli_stmt_init($conn);
 
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "SQL error";
    http_response_code(500);
}else{
    mysqli_stmt_bind_param($stmt,"sss",$_POST['email'],$_POST['password'],$_POST['phone']);
  
    if (mysqli_stmt_execute($stmt)) {
      echo "New record created successfully";
    
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
          }
 }
 }catch(exception $ex){
  http_response_code(500);
  echo 'Unable to signup';
  // echo '<form action="signup.php" method="post">
  // <label for="email">E-mail:</label><br>
  // <input type="text" placeholder="Enter email" name="email" value='.$_POST['email'].' required=""><br>
  // <label for="phone">Phone no.: </label><br>        
  // <input type="text" placeholder="Enter Phone no." name="phone" value='.$_POST['phone'].' required=""><br>
  // <label for="password">Password:</label><br>
  // <input type="text" placeholder="Enter Password" name="password" value='.$_POST['password'].'  required=""><br>
  // <label for="confirm password">Confirm Password:</label><br>
  //  <input type="text" placeholder="Re-enter Passsword" name="password" value='.$_POST['password'].'  required=""><br>
  
  // <input type="submit" name="signup">
  // </form>';
   exit();
 }
 
  if(isset($_POST['signup']) AND empty($emailErr) AND empty($phoneErr) AND empty($passwordErr) AND empty($entryerr)){
   
     header('location:login.php');
  }else{
    if(isset($entryerr)){
    echo $entryerr;
  }
}
  mysqli_close($conn);
}
}
   

 
  
   
    ?>
    <a href="\Event-manager\login.php" target="_blank">Login</a>


</body>
</html>