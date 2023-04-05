<?php
/*
if no session then redirect to login page

*/
?>
<?php
session_start();
print_r($_SESSION);
if(!isset($_SESSION['user_id']))
{
    echo 'no session';
    header("Location: login.php");

}
?>
<!doctype html>
<html>
<body>
<h1 style=" text-align:center">DASHBOARD</h1>  
<button onclick="document.location='create_org.php'">Create Organisation</button>
<button onclick="document.location='create-event.php'">Create Event</button>
<button onclick="document.location='logout.php'">Logout</button>


</body> 
</html>