<?php
include('config.php');
session_start();
if($_SESSION["role"] != "centre"){
  header("Location: logout.php");
}
?>

<?php
// define variables and set to empty values
$idErr = $emailErr = $returndateErr = $cpassErr ="";
$id = $email = $returndate = $cpass = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id"])) {
    $idErr = "This field is required";
  } else {
    $id = test_input($_POST["id"]);
    if(!preg_match("/^[0-9 ]*$/",$id)){
      $idErr = "Invalid Id format. Only numeric characters allowed.";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "This field is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["returndate"])) {
    $returndateErr = "This field is required";
  } else {
    $returndate = test_input($_POST["returndate"]);
  }

  if (empty($_POST["cpass"])) {
    $cpassErr = "Centre password is required";
  } else {
    $cpass = md5(test_input($_POST["cpass"]));
  }

  if(($cpass != $_SESSION["pass"])||($idErr!="")||($emailErr!="")||($returndateErr!="")){
    $err = "Please try again.";
  }

  else{
    $cid = $_SESSION["email"];
    $cname=$_SESSION["cname"];    
    $sql2 = "SELECT * FROM tblstudents where EmailId = '$email'";
    $res2 = $conn->query($sql2);
    $sql3 = "SELECT * FROM centre".$cid." where UId=".$id." and Issued is NULL";
    $res3 = $conn->query($sql3);
    if($res2->num_rows < 1){
      $err = "The student does not exist in our database.";
    }
    else if($res3->num_rows < 1){
      $err = "Equipment is not available.";
    }
    else{
      $sql4 = "UPDATE centre".$cid." SET Issued= 1,IssuerEmail= '$email',IssueDate=CURRENT_DATE,ReturnDeadline='$returndate' WHERE UId='$id'";
      if($conn->query($sql4)){
        $err = "Equipment issued succesfully.";
      }
      else{
        $err = "Not able to issue equipment.";
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
      <li class="nav-item active">
        <a class="nav-link" href="issue_equip.php">Issue Equipment</a>
      </li>
      <li class="nav-item">
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
<h2 class="card-title">Issue Equipment</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Equipment Id</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Equipment Id" name="id" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $idErr;?></small>
</div>

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Student email</label>
<input type="email" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Student Email" name="email" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $emailErr;?></small>
</div>

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Return Date</label>
<input type="date" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="returndate" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $returndateErr;?></small>
</div>

<div class="form-group">
<label for="exampleInputPassword1">Centre Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="cpass" style="width:600px;">
    <small id="cpassHelp" class="form-text text-muted"><?php echo $cpassErr;?></small>
</div>

<button type="submit" name="submit" class="btn btn-info">Issue Equipment</button><br><br>

</form>
<?php echo $err; ?>
</div>


</body>
</html>



