<?php
session_start();
if(isset($_SESSION['ShopName'])){
header("location: shophome.php");
}
//include('config.php');

$ShopNameError = $passwordError ="";
$ShopName = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["ShopName"])) {
    $ShopNameError = "Shop Id is required";
    $ShopName="";
  } else {
      $ShopName = $_POST["ShopName"];
      echo $ShopName;
    //$ShopName = test_input($_POST["ShopName"]);
    // // check if e-mail address is well-formed
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //   $emailErr = "Invalid email format";
    // }
//    if(!ctype_digit($email)){
//      $emailError = "Invalid Id format. Only numeric characters allowed.";
//    }
  }

  if (empty($_POST["password"])) {
    $passwordError = "Password is required";
    $password="";
  } else {
    $password = md5(test_input($_POST["password"]));
  } 

  $sql="SELECT * FROM `shoplist` WHERE `id`='$ShopName' AND `Password`='$password'";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
    $message="";
    $_SESSION["ShopName"] = $ShopName;
    $_SESSION["role"] = "shop";
    $_SESSION["password"] = $password;
    $row = $result->fetch_assoc();
    $_SESSION["cname"] = $row["ShopName"];
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
     <title>Bajaj Medical Agency</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css"> </head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Bajaj Medical Agency</a>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="index.php">Sign In</a>
      <a class="nav-item nav-link" href="newuser.php">Sign Up</a>
      <a class="nav-item nav-link active" href="shoplogin.php">Shop Login</a>
      <a class="nav-item nav-link" href="adminlogin.php">Admin Login</a>
    </div>
  </div>
</nav>
<br>
<div class="card" style="width:620px; align-self: center; align-items: center; margin-left: auto; margin-right: auto;" >
<h2 class="card-title">Shop Login</h2>

<br>
<form role="form" method="post" >

<div class="form-group" >
<label for="exampleInputEmail1" style="align:left">Shop Name</label>
<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Shop Name" name="ShopName" style="width:600px;">
<small id="passHelp" class="form-text text-muted"><?php echo $ShopNameError;?></small>
</div>
<div class="form-group">
<label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" style="width:600px;">
    <small id="passHelp" class="form-text text-muted"><?php echo $passwordError;?></small>
</div>


 <button type="submit" name="login" class="btn btn-info">LOGIN </button> <br><br>

</form>

<?php
echo $message;
?>
</div>
</body>
</html>