<?php
include('config.php');
session_start();
if($_SESSION["role"] != "centre"){
  header("Location: logout.php");
}
?>

<?php
// define variables and set to empty values
$idErr = $cpassErr ="";
$id = $cpass = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id"])) {
    $idErr = "This field is required";
  } else {
    $id = test_input($_POST["id"]);
    if(!preg_match("/^[0-9 ]*$/",$id)){
      $idErr = "Invalid Id format. Only numeric characters allowed.";
    }
  }

  if (empty($_POST["cpass"])) {
    $cpassErr = "Centre password is required";
  } else {
    $cpass = md5(test_input($_POST["cpass"]));
  }

  if(($cpass != $_SESSION["pass"])||($idErr!="")){
    $err = "Please try again.";
  }

  else{
    $cid = $_SESSION["email"];
    $cname=$_SESSION["cname"];    
    $sql3 = "SELECT * FROM centre".$cid." where UId=".$id." and Issued is not NULL";
    $res3 = $conn->query($sql3);
    if($res3->num_rows < 1){
      $err = "Equipment is not issued to anyone";
    }
    else{
      $sql4 = "UPDATE centre".$cid." SET Issued= NULL,IssuerEmail= NULL,IssueDate=NULL,ReturnDeadline=NULL WHERE UId='$id'";
      if($conn->query($sql4)){
        $err = "Equipment returned succesfully.";
      }
      else{
        $err = "Not able to return equipment.";
      }
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE HTML>  
<html>
<head>
<title>GnS Council</title>
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
        <a class="nav-link" href="shophome.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="addequip.php">Add Equipment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="delmedicines.php">Delete Equipment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="issue_equip.php">Issue Equipment</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="return_equip.php">Return Equipment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
    <span class="navbar-text">
      <b><?php echo $_SESSION["cname"];?></b> 
    </span>
  </div>
</nav>
<br>

<div class="card" style="width:620px; align-self: center; align-items: center; margin-left: auto; margin-right: auto;" >
<h2 class="card-title">Return Equipment</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Equipment Id of the equipment being returned</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Equipment Id" name="id" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $idErr;?></small>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Centre Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="cpass" style="width:600px;">
    <small id="cpassHelp" class="form-text text-muted"><?php echo $cpassErr;?></small>
</div>

<button type="submit" name="submit" class="btn btn-info">Return Equipment</button><br>
<br>

</form>
<?php echo $err; ?>
</div>
<br>

</body>
</html>