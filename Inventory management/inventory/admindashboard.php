<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
include 'connection.php';
$currentuserID = $_SESSION['userID'];


// SQL query to select and count Total Products
$sql1 = "SELECT COUNT(*) as countproducts FROM products";
// Execute query
$result1 = $connection->query($sql1);
// Check if query was successful
if ($result1 === false) {
  die("Error: " . $sql1 . "<br>" . $connection->error);
}
// Get the count of pending tasks
$counttotalproducts = $result1->fetch_assoc()["countproducts"];

// SQL query to select and count products out of stock
$sql = "SELECT COUNT(*) as countoutofstock FROM products WHERE product_quantity<=50";
// Execute query
$result = $connection->query($sql);
// Check if query was successful
if ($result === false) {
  die("Error: " . $sql . "<br>" . $connection->error);
}
// Get the count of products out of stock
$countproductsoutofstock = $result->fetch_assoc()["countoutofstock"];


// SQL query to select and count all Expiring Products
$numberofexpiringproducts = 0;
$sql2 = "SELECT expiry_date FROM products";
// Execute query
$result2 = $connection->query($sql2);
// Check if query was successful
if ($result2 === false) {
  die("Error: " . $sql2 . "<br>" . $connection->error);
}

// Get the count of pending tasks
//$countexpiringproducts = $result2->fetch_assoc()["countadmins"];

while ($row = mysqli_fetch_assoc($result2)) {


  $expiryDate = new DateTime($row['expiry_date']);
  //$dueDate = new DateTime($row['duedate']);
  $currentDateTime = new DateTime();
  $timeremaining = $currentDateTime->diff($expiryDate);
  $remainingHours = ($timeremaining->h + ($timeremaining->days * 24));

  if($remainingHours <= 240){
    $numberofexpiringproducts = $numberofexpiringproducts + 1;
  }

}

/*
//Get the admin code
$admincodeQuery = "SELECT admin FROM users WHERE userID = '$currentuserID'";

$admincodeResult = mysqli_query($connection, $admincodeQuery);

if ($admincodeResult && mysqli_num_rows($admincodeResult) > 0) {
	$admincodeRow = mysqli_fetch_assoc($admincodeResult);
	$admincode = $admincodeRow['admin'];
}
*/


?>

<!DOCTYPE HTML>
<HTML>
<h1>Admin Dashboard</h1>
<div class="dash">

<div class="users"><br>
<h1><?php echo ('<a href="?page=productssummary.php&tile=1" style="text-decoration: none; color: black;">'.$counttotalproducts.'</a>'); ?></h1>
<h2>Total Products</h2>
</div>

<div class="pendingtasks"><br>
<h1><?php echo ('<a href="?page=productssummary.php&tile=2" style="text-decoration: none; color: black;">'.$countproductsoutofstock.'</a>'); ?></h1>
<h2>Products Out of Stock</h2>
</div>

<div class="admins"><br>
<h1><?php echo ('<a href="?page=productssummary.php&tile=3" style="text-decoration: none; color: black;">'.$numberofexpiringproducts.'</a>'); ?></h1>
<h2>Products Expiring Soon</h2>
<h3>(in 10 days or less)</h3>
</div>


</div>
</HTML>

<?php
}elseif(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){
	header("location: loginregister.php");
	exit;
}

?>