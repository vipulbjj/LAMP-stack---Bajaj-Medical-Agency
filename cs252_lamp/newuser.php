
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
  <a class="navbar-brand" href="index.php">Bajaj Medical Agency</a>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Sign In</a>
      <a class="nav-item nav-link active" href="newuser.php">Sign Up</a>
      <a class="nav-item nav-link" href="shoplogin.php">Shop Login</a>
      <a class="nav-item nav-link" href="adminlogin.php">Admin Login</a>
    </div>
  </div>
</nav>

<?php

include('config.php');
// define variables and set to empty values
$usernameError = $emailError  = $passwordError = $cpasswordError = "";
$username = $email = $password = $cpassword = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["username"])) {
    $usernameError = "Username is required";
  } else {
    $username = sanitize_input($_POST["username"]);
    // check if username only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
      $usernameError = "Only letters and white space allowed";
    }
  }
  


  if (empty($_POST["email"])) {
    $emailError = "Email is required";
  } else {
    $email = sanitize_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email format";
    }
  }

  if (empty($_POST["password"])) {
    $passwordError = "password is required";
  } else {
    $password = md5(sanitize_input($_POST["password"]));
  }

  if (empty($_POST["cpassword"])) {
    $cpasswordError = "This is required";
  } else {
    $cpassword = md5(sanitize_input($_POST["cpassword"]));
  }

  if(($password != $cpassword)||($usernameError!="")||($passwordError!="")||($cpasswordError!="")||($emailError!="")){
    $err = "Please try again.";
  }
  else{
    $sql = "INSERT INTO `user`(`username`, `email`, `password`) VALUES ('$username','$email','$password')";
    if($conn->query($sql)){
    $err="Succesfully added new user.";
    header("location:index.php");
    }
    else{
      $err = "Not able to add user.";
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
<br>
<div class="card" style="width:620px; align-self: center; align-items: center; margin-left: auto; margin-right: auto;" >
<h2 class="card-title">Sign Up</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Username</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Username" name="username" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $usernameError;?></small>
</div>

<div class="form-group" >
<label for="exampleInputEmail1" style="align:left">Email address</label>
<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" style="width:600px;">
<small id="emailHelp" class="form-text text-muted"><?php echo $emailError;?></small>
</div>


<div class="form-group">
<label for="exampleInputpassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputpassword1" placeholder="password" name="password" style="width:600px;">
    <small id="passwordHelp" class="form-text text-muted"><?php echo $passwordError;?></small>
</div>

<div class="form-group">
<label for="exampleInputCpassword1">Confirm password</label>
    <input type="password" class="form-control" id="exampleInputCpassword1" placeholder="password" name="cpassword" style="width:600px;">
    <small id="cpasswordHelp" class="form-text text-muted"><?php echo $passwordError;?></small>
</div>
<button type="submit" name="submit" class="btn btn-info">Register</button><br>
<br>

</form>

<?php
echo $err;
?>

</div>
</body>
</html>
