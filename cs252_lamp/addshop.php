<?php
include('config.php');
session_start();
if($_SESSION["role"] != "admin"){
  header("Location: logout.php");
}
?>


<?php
// define variables and set to empty values
$nameError = $passwordError = $cpasswordError ="";
$name = $password = $cpassword = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameError = "Shop Name is required";
  } else {
    $name = sanitize_input($_POST["name"]);
  }
  
  if (empty($_POST["password"])) {
    $passwordError = "Admin password is required";
  } else {
    $password = md5(sanitize_input($_POST["password"]));
  }

  if (empty($_POST["cpassword"])) {
    $cpasswordError = "Shop password is required";
  } else {
    $cpassword = md5(sanitize_input($_POST["cpassword"]));
  }

  if(($password != $_SESSION["password"])||($nameError!="")||($passwordError!="")){
    $err = "Please try again.";
  }

  else{
    $sql = "INSERT INTO shoplist (ShopName,Password) VALUES ('$name','$cpassword')";
    if($conn->query($sql)){
      $sql2 = "SELECT * FROM shoplist WHERE ShopName='$name'";
      //echo $sql2;
      $res2 = $conn->query($sql2);
      if($res2->num_rows>0){
        $row = $res2->fetch_assoc();
        $id = $row["id"];
        $sql3 = "CREATE TABLE shop".$id." ( id INT NOT NULL AUTO_INCREMENT , DrugCode INT, DrugName VARCHAR(256) NOT NULL , Unit VARCHAR(256) NOT NULL , Price VARCHAR(256) , Quantity INT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB ";

        $res3 = $conn->query($sql3);
        if($res3){
          $err = "Shop added succesfully.";
        }
        else{
          $err = "Not able to add create table."; 
        }
      }
      else{
        $err = "Shop not found.";
      }
    }
    else{
      $err = "Not able to add shop.";
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
      <li class="nav-item active">
        <a class="nav-link" href="addshop.php">Add Shop</a>
      </li>
      <li class="nav-item">
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
<h2 class="card-title">Add New Shop</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Shop Name</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="name" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $nameError;?></small>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Shop Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="cpassword" style="width:600px;">
    <small id="cpasswordHelp" class="form-text text-muted"><?php echo $cpasswordError;?></small>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Admin Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" style="width:600px;">
    <small id="passwordHelp" class="form-text text-muted"><?php echo $passwordError;?></small>
</div>


<button type="submit" name="submit" class="btn btn-info">Add Shop</button><br>
<br>

</form>
<?php echo $err; ?>
</div>
</body>
</html>
