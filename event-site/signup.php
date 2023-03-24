<html>
<body>
    
<h1 style=" text-align:center">SIGNUP</h1>  
<div class="container" style="text-align:center;color:black;padding:30px;">
<form action="signup.php" method="post">
<label for="email">E-mail:</label><br>
<input type="text" placeholder="Enter email" name="email"><br>
<label for="phone">Phone no.: </label><br>        
<input type="text" placeholder="Enter Phone no." name="phone"><br>
<label for="password">Password:</label><br>
<input type="text" placeholder="Enter Password" name="password"><br>
<label for="confirm password">Confirm Password:</label><br>
 <input type="text" placeholder="Re-enter Passsword" name="password"><br>

<input type="submit">
</form>
</div>
<?php
    if(!empty($_POST)){
        echo "email=" . $_POST['email'] ." <br>";
        echo "NO.=" . $_POST['phone'] ." <br>";

    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            
   
    
    $sql="insert into users(email , password , phone_number) values('".$_POST['email']."','".$_POST['password']."','".$_POST['phone']."')";
 
    mysqli_close($conn);
    ?>
    <a href="\Ayush\event-site\login.php" target="_blank">Login</a>


</body>
</html>