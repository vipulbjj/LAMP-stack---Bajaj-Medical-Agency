<?php
session_start();
if(isset($_SESSION['email'])){
header("location: shophome.php");
}
include('config.php');

$emailErr = $passErr ="";
$email = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["emailid"])) {
    $emailErr = "Centre Id is required";
    $email="";
  } else {
    $email = test_input($_POST["emailid"]);
    // // check if e-mail address is well-formed
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //   $emailErr = "Invalid email format";
    // }
    if(!ctype_digit($email)){
      $emailErr = "Invalid Id format. Only numeric characters allowed.";
    }
  }

  if (empty($_POST["password"])) {
    $passErr = "Password is required";
    $pass="";
  } else {
    $pass = md5(test_input($_POST["password"]));
  } 

  $sql="SELECT * FROM `centrelist` WHERE `CentreId`='$email' AND `Password`='$pass'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    $message="";
    $_SESSION["email"] = $email;
    $_SESSION["role"] = "centre";
    $_SESSION["pass"] = $pass;
    $row = $result->fetch_assoc();
    $_SESSION["cname"] = $row["CentreName"];
    header("location:shophome.php");
  }
  else{
    $message="Login unsuccesful";
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<!DOCTYPE html>
<html>
<head>
     <title>GnS Council</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css"> </head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">GnS</a>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Sign In</a>
      <a class="nav-item nav-link" href="newuser.php">Sign Up</a>
      <a class="nav-item nav-link active" href="shoplogin.php">Centre Login</a>
      <a class="nav-item nav-link" href="adminlogin.php">Admin Login</a>
    </div>
  </div>
</nav>
<br>
<div class="card" style="width:620px; align-self: center; align-items: center; margin-left: auto; margin-right: auto;" >
<h2 class="card-title">Centre Login</h2>

<br>
<form role="form" method="post" >

<div class="form-group" >
<label for="exampleInputEmail1" style="align:left">Centre Id</label>
<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Centre Id" name="emailid" style="width:600px;">
<small id="passHelp" class="form-text text-muted"><?php echo $emailErr;?></small>
</div>
<div class="form-group">
<label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" style="width:600px;">
    <small id="passHelp" class="form-text text-muted"><?php echo $passErr;?></small>
</div>


 <button type="submit" name="login" class="btn btn-info">LOGIN </button> <br><br>

</form>

<?php
echo $message;
?>
</div>
</body>
</html>