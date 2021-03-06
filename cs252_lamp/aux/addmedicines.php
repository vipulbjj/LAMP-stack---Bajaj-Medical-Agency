<?php
include('config.php');
session_start();
if($_SESSION["role"] != "shop"){
  header("Location: logout.php");
}
?>

<?php
// define variables and set to empty values
$DrugCodeErr = $DrugNameErr = $UnitErr = $cpassErr ="";
$DrugCode = $DrugName = $Unit = $Price = $Quantity =$cpass = $err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["DrugCode"])) {
    $DrugCodeErr = "This field is required";
  } else {
    $DrugCode = sanitize_input($_POST["DrugCode"]);
  }

  if (empty($_POST["DrugName"])) {
      $DrugNameErr = "This field is required";
  } else {
    $DrugName = sanitize_input($_POST["DrugName"]);
  }

    if (empty($_POST["Unit"])) {
        $UnitErr = "This field is required";
    } else {
        $Unit = sanitize_input($_POST["Unit"]);
    }

  $Price = ($_POST["Price"]);
    $Quantity = ($_POST["Quantity"]);

  if (empty($_POST["cpass"])) {
    $cpassErr = "Centre password is required";
  } else {
    $cpass = md5(sanitize_input($_POST["cpass"]));
  }

  if(($cpass != $_SESSION["pass"])||($DrugCodeErr!="")||($DrugNameErr!="")||($UnitErr!="")||($cpassErr!="")){
    $err = "Please try again.";
  }

  else{
    $cid = $_SESSION["email"];
    $cname=$_SESSION["cname"];
    $sql = "INSERT INTO shop".$_SESSION["email"]." (Sport,Equipment,Remarks,CentreId,CentreName) VALUES ('$sport','$equipment','$remarks','$cid','$cname')";
    if($conn->query($sql)){
      $err = "Medicine added";
    }
    else{
      $err = "Not able to add medicine";
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
      <li class="nav-item active">
        <a class="nav-link" href="addmedicines.php">Add Equipment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="delmedicines.php">Delete Equipment</a>
      </li>
      <li class="nav-item">
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
<h2 class="card-title">Add New Equipment</h2>
<!-- <p><span class="error">* required field</span></p>
 -->
 <form method="post" role ="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Sport</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="sport" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $sportErr;?></small>
</div>

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Equipment</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="equipment" style="width:600px;">
<small id="nameHelp" class="form-text text-muted"><?php echo $equipmentErr;?></small>
</div>

<div class="form-group" >
<label for="exampleInputName1" style="align:left">Remarks</label>
<input type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="remarks" style="width:600px;">
</div>

<div class="form-group">
<label for="exampleInputPassword1">Centre Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="cpass" style="width:600px;">
    <small id="cpassHelp" class="form-text text-muted"><?php echo $cpassErr;?></small>
</div>

<button type="submit" name="submit" class="btn btn-info">Add Equipment</button><br>
<br>

</form>
<?php echo $err; ?>
</div>
</body>
</html>



