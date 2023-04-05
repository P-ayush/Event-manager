<?php
/*
if session active then redirect to dashboard
if post data fetch from mysql
if no data in mysql then show user doesn't exist 
if password doesn't match -> incorrect password
if the post data matches then create session and redirect to dashboard
if no post data then show signup page


fetch user_id from session and save as foriegn key 
*/
?>
<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
}
$servername = "localhost";
$username = "root";
$password = "";
$database="event_site";
$conn = mysqli_connect($servername,
            $username, $password,$database) or die ('unable to connect')
?>
<html>
<body>
<h1 style=" text-align:center">LOGIN</h1>  
<form action="login.php" method="post">
<label for="email">E-mail:</label><br>
<input type="text" name="email" required=""><br>
<label for="password">Password:</label><br>
<input type="text" name="password" required=""><br>


<input type="submit" name="login" value="login">
</form>
<?php
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $select= mysqli_query($conn,"select user_id  from users where email='$email' and password='$pass'");
    $row=mysqli_fetch_array($select);
    
    if(is_array($row)){
        $_SESSION['user_id']=$row['user_id'];
      
      header('location:dashboard.php'); 
      
    } else{
        echo '<script>';
        echo 'alert("Invalid Username or Password")';
        echo '</script>';
    }
}

?>
<a href="\Ayush\event-site\signup.php" target="_blank">Sign-up</a>

    

</body>
</html>