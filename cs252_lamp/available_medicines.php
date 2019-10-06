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
<link rel="stylesheet" href="style.css"> </head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="userhome.php">Home</a>
      </li>
      <li class="nav-item active">
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
<h3>Available Medicines</h3>
<?php
$query="select * from shoplist";
$result= $conn->query($query);
$email=$_SESSION["email"];
$count = 0;
$shops=array();
$c_names=array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        array_push($shops, "shop".$row["id"]);
        array_push($c_names, $row["ShopName"]);
        $count +=1;
    }
    //echo $shops[0];
}

for($i=0;$i<$count;$i++){
	$count2=0;
//	$sql="SELECT * FROM ".$shops[$i]."
    $sql="SELECT * FROM ".$shops[$i];
    $res = $conn->query($sql);
//    echo $res->num_rows;
//    echo "<p>$res->num_rows</p>";
    //echo "abc";
	if($res->num_rows > 0){
		while($row = $res->fetch_assoc()){
			if($count2==0){
				echo "<center><h5>".$c_names[$i]."</h5></center>";
	            echo "<div class=\"container\">";
	            echo "<table class=\"table table-bordered\">";
	            echo "<thead>";
	            echo "<tr>";
	            echo "<th>DrugCode</th>";
	            echo "<th>DrugName</th>";
	            echo "<th>Unit</th>";
	            echo "<th>Price</th>";
	            echo "</tr>";
			}
//			echo "<p>".$row['COL 1']."</p>";
			$count2 += 1;
			echo "<tr>";
	        echo "<td>".$row['COL 2']."</td>";
	        echo "<td>".$row["COL 3"]."</td>";
	        echo "<td>".$row["COL 4"]."</td>";
	        echo "<td>".$row["COL 5"]."</td>";
	        echo "</tr>";
		}
	}
	if($count2>0){
    echo "</tbody>";
    echo "</table> </div>";
	}
}


?>

</center>
</body>
</html>