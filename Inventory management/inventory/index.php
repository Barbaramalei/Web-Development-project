<?php
session_start();
include 'connection.php';
include 'inactivity.php';
include 'tables.php';

$deviceInfo = $_SERVER['HTTP_USER_AGENT'];
?>

<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
?>

<!DOCTYPE HTML>
<HTML>
<link rel = "stylesheet" type = "text/css" href = "admin.css">
<head>
<title>Admin Panel</title>
</head>

<body>

<div class = "navbar">

<div class = "login">

  <?php
	$username = $_SESSION['username'];
	$_SESSION['username'] = $username;
	$currentuserID = $_SESSION['userID'];
	$_SESSION['userID'] = $currentuserID;
	$sessionID = $_SESSION['session_id'];
	$_SESSION['session_id'] = $sessionID;

	$deviceInfo = $_SESSION['deviceInfo'];

	$getCurrentSessionQuery = "SELECT session_id FROM sessions WHERE user_id = $currentuserID AND device_info = '$deviceInfo'";
	$currentSessionResult = mysqli_query($connection, $getCurrentSessionQuery);
	if ($currentSessionResult && mysqli_num_rows($currentSessionResult) > 0) {

	// Retrieve the admin value from 'users' table
	$adminstatusQuery = "SELECT admin FROM users WHERE userID = '$currentuserID'";
	$adminstatusResult = mysqli_query($connection, $adminstatusQuery);

	if ($adminstatusResult && mysqli_num_rows($adminstatusResult) > 0) {
		$adminstatusRow = mysqli_fetch_assoc($adminstatusResult);
		$adminvalue = $adminstatusRow['admin'];

		if($adminvalue != 11){
			header('Location: otheradmin.php');
			exit;
		}

	}

	
	echo '<div class="myname">';
	echo '
 <select name="forma" onchange="location = this.value;">
 <option value="">';
 echo ($username);
 echo '</option>';

 echo '<option value="logout.php">Log Out</option>';
 echo '</select>';

echo '</div>';

	//sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss
	
	echo '
	<style>
	
	.login div{
	width: auto;
	text-align: centre;
	display: inline-block;
	margin-right: 12px;
	//border: 2px solid blue;
} 


.login {
	display: flex;
	justify-content: flex-end;
	align-items: center;
	padding-left: 120px;
	background-color: lightgrey;
	padding: 5px;
	//border: 2px solid black;
	
}

.login a h4 {
	font-size: 20px;
	color: black;
	transition: transform .3s;
	
}

.login a h4:hover{
	background-color: white;
	color: black;
	transform: scale(1.2);
	transition: transform .3s;
	
}

@media only screen and (max-width: 1250px) {
	.login div{
		width: 100%
	}
	
	.notlogged{
		display: none;
	}
	
}
	
	</style>';
?>

<!--!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->

</div>

</div>

<div class="wrapper">
			<nav>
				<ul>
					<li><a href="?page=admindashboard.php">Dashboard</a></li>
					<li><a href="?page=products.php">Products</a></li>
					<li><a href="?page=addproducts.php">Add</a></li>
				</ul>
			</nav>
		<div class="content">
			<?php 
				if(isset($_GET['page'])) {
					$page = $_GET['page'];
					//include $page . '.php';
					include $page;
				}
				else {
					include 'admindashboard.php';
				}
			?>
		</div>
</div>

</body>

</HTML>

<?php

// Update the last activity time
$_SESSION['last_activity'] = time();

// Update last activity on every user interaction (e.g., on each page load)
$updateLastActivityQuery = "UPDATE sessions SET last_activity = NOW() WHERE session_id = '$sessionID'";
$connection->query($updateLastActivityQuery);

// Close the database connection
mysqli_close($connection);
}else{
header("location: logout.php");
	exit;
}

}elseif(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){
	header("location: loginregister.php");
	exit;
}

?>