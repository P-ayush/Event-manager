<!doctype html>
<html>
<body>   
<p style="font-size:160%;text-align:center">Invite Participants</P>
<form action="invite-participants.php" method="post">
<label for="status">Status:</label><br>
<input type="text" name="status"><br>
<label for="name">Name:</label><br>        
<input type="text" name="name"><br>
<label for="email">E-mail:</label><br>        
<input type="text" name="email"><br>


<input type="submit">
</form>
<?php
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            

    $sql="insert into participants(name,status,email) values('".$_POST['name']."','".$_POST['status']."','".$_POST['email']."')";
   
    mysqli_close($conn);
    ?>
    
</body> 
</html>