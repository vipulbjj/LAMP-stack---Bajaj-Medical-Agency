<?php
include('config.php');
session_start();
if($_SESSION["role"] != "admin"){
	header("Location: logout.php");
	echo $_SESSION["role"];
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
      <li class="nav-item active">
        <a class="nav-link" href="adminhome.php">Home</a>
      </li>
      <li class="nav-item">
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


<center>
<h2>Welcome!</h2>
</center>
<?php
$query="select * from shoplist";
$result= $conn->query($query);

$count = 0;
if($result->num_rows > 0)
{
    while($row = $result->fetch_assoc())
    {

        if($count == 0)
        {
            echo "<center><h5>Currently Active Shops</h5></center>";
            echo "<div class=\"container\" style=\"width:400px;\">";
            echo "<table class=\"table table-bordered\">";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Unique Shop Id</th>";
            echo "<th>Shop Name</th>";
            echo "</tr>";
        }
        $count=$count+1;
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["ShopName"]."</td>";
        echo "</tr>";
   
    }
}
if($count>0)
{
    echo "</tbody>";
    echo "</table> </div>";
}
?>

</body>
</html>