<?php
include('config.php');
session_start();
if($_SESSION["role"] != "user"){
	header("Location: logout.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bajaj Medical Agency</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style.css"> </head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="userhome.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="available_medicines.php">Available Medicines</a>
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

<center>
<h3>Welcome!</h3>
<?php
$query="select * from shoplist";
$result= $conn->query($query);
$email=$_SESSION["email"];
$count = 0;
$shops=array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        array_push($shops, "shop".$row["ShopId"]);
        $count +=1;
    }
}
$count2=0;
for($i=0;$i<$count;$i++){
	$sql="SELECT * FROM ".$shops[$i]." where IssuerEmail='$email'";
	$res = $conn->query($sql);
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			if($count2==0){
				echo "<center><h5>Currently issued equipments</h5></center>";
	            echo "<div class=\"container\">";
	            echo "<table class=\"table table-bordered\">";
	            echo "<thead>";
	            echo "<tr>";
	            echo "<th>Drug Code</th>";
	            echo "<th>Drug Name</th>";
	            echo "<th>Unit</th>";
	            echo "<th>Price</th>";
	            echo "<th>Quantity</th>";
//	            echo "<th>Issue Date</th>";
//	            echo "<th>Return Deadline</th>";
	            echo "</tr>";
			}
			$count2 += 1;
			echo "<tr>";
	        echo "<td>".$row["Drug Code"]."</td>";
	        echo "<td>".$row["Drug Name"]."</td>";
	        echo "<td>".$row["Unit"]."</td>";
	        echo "<td>".$row["Price"]."</td>";
	        echo "<td>".$row["Quantity"]."</td>";
//
	        echo "</tr>";
		}
	}
}
if($count2>0){
    echo "</tbody>";
    echo "</table> </div>";
}

?>

</center>
</body>
</html>