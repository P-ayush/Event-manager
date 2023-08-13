<?php
/*
if session not active then redirect to login page
if post data then validate insert into mysql 

*/
?>
<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
}
$name=$address="";
?>
<!doctype html>
<html>
<body>
<h1 style="font-size:160%;text-align:center">Create Organisation</h1>
<form action="create_org.php" method="post" enctype="multipart/form-data">
<label for="name">Name:</label><br>
<input type="text" placeholder="Enter Name" name="name" value= '<?php if(!empty($_POST['address'])){echo $_POST['name'];}else{echo $name;} ?>' required=""><br>
<label for="address">Address: </label><br>        
<input type="text"  placeholder="Enter Address" name="address" value= '<?php if(!empty($_POST['address'])){echo $_POST['address'];}else{echo $address;} ?>' required=""><br>
<label for="myfile">Logo/cover photo:</label><br>
 <input type="file" id="myfile" name="myfile" required="" accept="image/*" ><br><div id="fileResult"></div> <div id="fileSubmit"></div>
 <script> 
 let myfile = document.getElementById("myfile");
let fileResult = document.getElementById("fileResult");
let fileSubmit = document.getElementById("fileSubmit");
 myfile.addEventListener("change", function () {  
  if (myfile.files.length > 0) {
    const fileSize = myfile.files.item(0).size;
    const fileMb = fileSize / 1024 ** 2;
    alert(fileMb);
  
if (fileMb >= 2) {
      fileResult.innerHTML = "Please select a file less than 2MB.";
      fileSubmit.disabled = true;
    } else {
      fileResult.innerHTML = "Success, your file is " + fileMb.toFixed(1) + "MB.";
      fileSubmit.disabled = true;
    }
  }
});
</script>
<input type="submit" name="create_org" >
</form>
<?php
// if(isset($_POST['create_org'])){
//   $file_name=$_FILES['myfile']['name'];
//   $file_size=$_FILES['myfile']['size'];
//   $file_type=$_FILES['myfile']['type'];
//   $file_tmp=$_FILES['myfile']['tmp_name'];
//   $file_store="uploads/".$file_name;
//   if(move_uploaded_file($file_tmp,$file_store)){
//     echo "image uploaded";
//   }
// }
if(isset($_POST)){
    
    if (!isset($_POST['name'], $_POST['address'])) { 
	
        echo 'Please complete the organisation details!';
    }else{
        
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="event_site";
    
    try{
      $conn = mysqli_connect($servername,
            $username, $password,$database);

        $sql1="select name from organisation where status ='active' and name=? and user_id=?";  //per user
        $stmt1=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt1,$sql1)){
            echo "SQL error";
            http_response_code(500);
        }else{
            mysqli_stmt_bind_param($stmt1,"ss",$_POST['name'],$_SESSION['user_id']);
            mysqli_stmt_execute($stmt1);
           
            $result1= mysqli_stmt_get_result($stmt1);
           
        }
        // echo $sql1;
        // $result1=mysqli_query($conn,$sql1);
        $row = mysqli_fetch_assoc($result1);
        $name=$_POST['name'];
        $address=$_POST['address'];
        if($_POST['name']== $row['name']){
          http_response_code(400);//duplicate entry
          
      $err="This name already used, use another ";
    
       }
       
       if(empty($err)){
    $sql="insert into organisation(name, address,user_id,status,image) values(?,?,?,'active',?)";
    $stmt=mysqli_stmt_init($conn);
       
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "SQL error";
      http_response_code(500);
  }else{
      mysqli_stmt_bind_param($stmt,"ssss",$_POST['name'],$_POST['address'],$_SESSION['user_id'],$_FILES['myfile']['name']);
      mysqli_stmt_execute($stmt);
  
      $result= mysqli_stmt_get_result($stmt);
     
  }
}
}catch(exception $ex){
    http_response_code(500);
    echo 'Something went wrong.
    try again';
    // echo '<form action="create_org.php" method="post">
    // <label for="name">Name:</label><br>
    // <input type="text" placeholder="Enter Name" name="name" value='.$_POST['name'].' required=""><br>
    // <label for="address">Address: </label><br>        
    // <input type="text"  placeholder="Enter Address" name="address" value='.$_POST['address'].'  required=""><br>
    // <input type="submit" name="create_org" >
    // </form>';
    exit();
}
 
    if(isset($_POST['create_org']) AND empty($err)){
      $file_name=$_FILES['myfile']['name'];
      $file_size=$_FILES['myfile']['size'];
      $file_type=$_FILES['myfile']['type'];
      $file_tmp=$_FILES['myfile']['tmp_name'];
      $file_store="uploads/".$file_name;
      if(move_uploaded_file($file_tmp,$file_store)){
        echo "image uploaded";
      }
          header('location:list-org.php');
            }else{
              echo $err;
            }
            mysqli_close($conn);
           
 }
 
}

    ?>

    </body> 
</html>