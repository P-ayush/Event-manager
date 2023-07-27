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
<h1 style=" text-align:center">EVENTS</h1> 
<p style="font-size:180%">Create Event</P> 
<form action="temp.php" method="post">
<label for="event_name">Event Name: </label><br>        
<input type="text" placeholder="Enter event name" name="event_name"  value= '<?php if(!empty($_POST['event_name'])){echo $_POST['event_name'];}else{echo "";} ?>' required=""><br>
<label for="location">Location:</label><br>
<input type="text" placeholder="Enter Location" name="location"  value= '<?php if(!empty($_POST['location'])){echo $_POST['location'];}else{echo "";} ?>'   required=""><br>
<label for="start_time">Start Time:</label><br>
 <input type="text" placeholder="Enter start-time"name="start_time"  value= '<?php if(!empty($_POST['start_time'])){echo $_POST['start_time'];}else{echo "";} ?>' required=""><br>
 <label for="end_time">End Time:</label><br>
 <input type="text" placeholder="Enter end-time" name="end_time" value= '<?php if(!empty($_POST['end_time'])){echo $_POST['end_time'];}else{echo "";} ?>'  required=""><br>
 <label for="max_participants">Maximum Participants:</label><br>
 <input type="text" placeholder="Enter max participants" name="max_participants" value= '<?php if(!empty($_POST['max_participants'])){echo $_POST['max_participants'];}else{echo "";} ?>' required=""><br>
 <label for="reg_close">Registration Close:</label><br>
 <input type="text" name="reg_close" value= '<?php if(!empty($_POST['reg_close'])){echo $_POST['reg_close'];}else{echo "";} ?>'   required=""><br>
<input type="submit" name ="create_event" >
</form> 

<?php
if(isset($_POST)){
    if (!isset($_POST['event_name'], $_POST['location'], $_POST['start_time'],$_POST['end_time'], $_POST['max_participants'], $_POST['reg_close'])) { 
	
        echo 'Please complete the event details!';
    }else{

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
   try{ $conn = mysqli_connect($servername,
            $username, $password,$database);
            
            $sql1="select event_name from event where status ='active' and event_name='".$_POST['event_name']."'";  
            $result1=mysqli_query($conn,$sql1);
            $row = mysqli_fetch_assoc($result1);
           
            if($_POST['event_name']== $row['event_name']){
              http_response_code(400);//duplicate entry
              
          $err="This name already used, use another ";
        
           }
           
           if(empty($err)){
    
    $sql="insert into event(event_name,location,start_time,end_time,maximum_participants,registration_close,user_id,status) values(?,?,?,?,?,?,?,'active')";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL error";
      http_response_code(500);
  }else{
      mysqli_stmt_bind_param($stmt,"sssssss",$_POST['event_name'],$_POST['location'],$_POST['start_time'],$_POST['end_time'],$_POST['max_participants'],$_POST['reg_close'],$_SESSION['user_id']);
      mysqli_stmt_execute($stmt);
      $result= mysqli_stmt_get_result($stmt);
    
  }
}
   }catch(exception $ex){
    http_response_code(500);
    echo 'unable to create event.
    Try again';
    
//   echo'  <form action="create-event.php" method="post">
// <label for="event_name">Event Name: </label><br>        
// <input type="text" placeholder="Enter event name" name="event_name" value='.$_POST['event_name'].' required=""><br>
// <label for="location">Location:</label><br>
// <input type="text" placeholder="Enter Location" name="location"  value='.$_POST['location'].' required=""><br>
// <label for="start_time">Start Time:</label><br>
//  <input type="text" placeholder="Enter start-time"name="start_time"   value='.$_POST['start_time'].'required=""><br>
//  <label for="end_time">End Time:</label><br>
//  <input type="text" placeholder="Enter end-time" name="end_time"   value='.$_POST['end_time'].'required=""><br>
//  <label for="max_participants">Maximum Participants:</label><br>
//  <input type="text" placeholder="Enter max participants" name="max_participants"  value='.$_POST['max_participants'].' required=""><br>
//  <label for="reg_close">Registration Close:</label><br>
//  <input type="text" name="reg_close"  value='.$_POST['reg_close'].' required=""><br>
// <input type="submit" name ="create_event" >
// </form> ';
exit();
   }
  mysqli_close($conn);
    if(isset($_POST['create_event']) AND empty($err)){
        header('location:list-event-org_id.php');
    }else{
        echo $err;
      }
     
}

}

    ?>
</body> 
</html>