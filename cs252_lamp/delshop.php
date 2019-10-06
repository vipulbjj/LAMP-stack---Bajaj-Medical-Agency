<?php
include('config.php');
session_start();
if($_SESSION["role"] != "admin"){
  header("Location: logout.php");
}
?>


<?php
// define variables and set to empty values
$idError = $passwordError ="";
$id = $password = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id"])) {
    $idError = "This field is required";
  } else {
    $id = sanitize_input($_POST["id"]);
    if(!preg_match("/^[0-9 ]*$/",$id)){
      $idError = "Invalid Id format. Only numeric characters allowed.";
    }
  }

  if (empty($_POST["password"])) {
    $passwordError = "Admin password is required";
  } else {
    $password = md5(sanitize_input($_POST["password"]));
  }

  if(($password != $_SESSION["password"])||($idError!="")){
    $err = "Please try again.";
  }

  else{
    $cname=$_SESSION["cname"];    
    $sql3 = "SELECT * FROM shoplist where id=".$id ;
    $res3 = $conn->query($sql3);
    if($res3->num_rows < 1){
      $err = "No such shop exists.";
    }
    else{
      $sql4 = "delete from shoplist WHERE id='$id'";
      if($conn->query($sql4)){
        $sql5 = "DROP TABLE shop".$id;
        if($conn->query($sql5)){
          $err = "Shop Deleted Successfully";
        }
        else{
          $err = "Not able to delete shop";
        }
      }
      else{
        $err = "Not able to delete shop";
      }
    }
  }
}

function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<!DOCTYPE HTML>  
<html>
<head>
<title>Bajaj Medical Agency</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
.error {color: #FF0000;}
</style>
<link rel="stylesheet" href="style.css"> </head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="adminhome.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="addshop.php">Add Shop</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="delshop.php">Delete Shop</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
    <span class="navbar-text">
      <b><?php echo $_SESSION["email"];?></b> 
    </span>
  </div>
</nav>

 
<br>
<div class="card" style="width:620px; align-self: center; align-items: center; margin-left: auto; margin-right: auto;" >
<h2 class="card-title">Delete Shop</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Shop Id of the Shop being deleted</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Equipment Id" name="id" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $idError;?></small>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Admin Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" style="width:600px;">
    <small id="passwordHelp" class="form-text text-muted"><?php echo $passwordError;?></small>
</div>


<button type="submit" name="submit" class="btn btn-info">Delete Shop</button><br><br>

</form>

</body>
</html>
