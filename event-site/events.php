<!doctype html>
<html>
<body>
<h1 style=" text-align:center">EVENTS</h1> 
<p style="font-size:180%">Create Event</P> 
<form action="events.php" method="post">
<label for="email">E-mail:</label><br>
<input type="text" placeholder="Enter E-mail" name="email"><br>
<label for="event_name">Event Name: </label><br>        
<input type="text" placeholder="Enter event name" name="event_name"><br>
<label for="location">Location:</label><br>
<input type="text" placeholder="Enter Location" name="location"><br>
<label for="start_time">Start Time:</label><br>
 <input type="text" placeholder="Enter start-time"name="start_time"><br>
 <label for="end_time">End Time:</label><br>
 <input type="text" placeholder="Enter end-time" name="end_time"><br>
 <label for="max_participants">Maximum Participants:</label><br>
 <input type="text" placeholder="Enter max participants" name="max_participants"><br>
 <label for="reg_close">Registration Close:</label><br>
 <input type="text" name="reg_close"><br>
<input type="submit">
</form> 

<?php
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    $conn = mysqli_connect($servername,
            $username, $password,$database);
            
   
    
    $sql="insert into event(email,event_name,location,start_time,end_time,maximum_participants,registration_close) values('".$_POST['email']."','".$_POST['event_name']."','".$_POST['location']."','".$_POST['start_time']."','".$_POST['end_time']."','".$_POST['max_participants']."','".$_POST['reg_close']."')";
  
    mysqli_close($conn);
    ?>
</body> 
</html>