<?php
/*
dashboard>events>list>invite_participants
*/
?>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
}

?>
<!doctype html>
<html>
<body>   
<p style="font-size:160%;text-align:center">Invite Participants</P>
<form action="invite-participants.php" method="post">
<label for="status">Status:</label><br>
<input type="text" name="status"  required=""><br>
<label for="name">Name:</label><br>        
<input type="text" name="name"  required=""><br>
<label for="email">E-mail:</label><br>        
<input type="text" name="email"  required=""><br>


<input type="submit">
</form>
<?php
    if(isset($_POST)){
        if(!isset($_POST['status'], $_POST['name'],$_POST['email'])){
            echo 'Please enter detail';
        }else{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
      $fetch= mysqli_query($conn, "select * from event where user_id=". $_SESSION['user_id']);   
       $row=mysqli_fetch_array($fetch);
    
       if(is_array($row)){
           $_SESSION['event_id']=$row['event_id']; 
    $sql="insert into participants(name,status,email,event_id) values('".$_POST['name']."','".$_POST['status']."','".$_POST['email']."','".$_SESSION['event_id']."')";
   

    mysqli_query($conn, $sql);
    mysqli_close($conn);
    }
}
    }
    ?>
    
</body> 
</html>