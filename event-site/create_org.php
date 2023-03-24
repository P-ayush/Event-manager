<!doctype html>
<html>
<body>
<h1 style="font-size:160%;text-align:center">Create Organisation</h1>
<form action="create_org.php" method="post">
<label for="name">Name:</label><br>
<input type="text" placeholder="Enter Name" name="name"><br>
<label for="address">Address: </label><br>        
<input type="text"  placeholder="Enter Address" name="address"><br>


<input type="submit">
</form>
<?php
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            
    $sql="insert into organisation(name, address) values('".$_POST['name']."','".$_POST['address']."')";
    
    mysqli_close($conn); 
    ?>

    </body> 
</html>