<?php
include('config.php');
session_start();
if($_SESSION["role"] != "centre"){
	header("Location: logout.php");
	echo $_SESSION["role"];
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
        <a class="nav-link" href="shophome.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="addmedicines.php">Add Medicines</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="delmedicines.php">Delete Medicines</a>
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

<center>
<h2>Welcome!</h2>

<?php
$cid = $_SESSION["email"];
$query="select * from shop".$cid;
$result= $conn->query($query);

$count = 0;
//echo $query;
if($result->num_rows > 0)
{

    while($row = $result->fetch_assoc())
    {

        if($count == 0)
        {
            echo "<center><h5>Medicines available for selling</h5></center>";
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
        $count=$count+1;
        echo "<tr>";
        echo "<td>".$row['COL 2']."</td>";
        echo "<td>".$row["COL 3"]."</td>";
        echo "<td>".$row["COL 4"]."</td>";
        echo "<td>".$row["COL 5"]."</td>";
        echo "</tr>";
    }
}
if($count>0)
{
    echo "</tbody>";
    echo "</table> </div>";
}
?>
<br>

<?php
$cid = $_SESSION["email"];
$query="select UId,Sport,Equipment,Remarks,IssuerEmail,IssueDate,ReturnDeadline from centre".$cid." where Issued is not NULL";
$result= $conn->query($query);

$count = 0;

if($result->num_rows > 0)
{

    while($row = $result->fetch_assoc())
    {

        if($count == 0)
        {
            echo "<center><h5>Currently issued equipments</h5></center>";
            echo "<div class=\"container\">";
            echo "<table class=\"table table-bordered\">";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Equipment Id</th>";
            echo "<th>Sport</th>";
            echo "<th>Equipment</th>";
            echo "<th>Remarks</th>";
            echo "<th>Student</th>";
            echo "<th>Issue Date</th>";
            echo "<th>Return Deadline</th>";
            echo "</tr>";
        }
        $count=$count+1;
        echo "<tr>";
        echo "<td>".$row["UId"]."</td>";
        echo "<td>".$row["Sport"]."</td>";
        echo "<td>".$row["Equipment"]."</td>";
        echo "<td>".$row["Remarks"]."</td>";
        echo "<td>".$row["IssuerEmail"]."</td>";
        echo "<td>".$row["IssueDate"]."</td>";
        echo "<td>".$row["ReturnDeadline"]."</td>";
        echo "</tr>";
    }
}
if($count>0)
{
    echo "</tbody>";
    echo "</table> </div>";
}
?>

</center>
</body>
</html>







