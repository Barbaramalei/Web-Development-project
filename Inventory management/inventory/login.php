<?php
session_start();
?>

<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
    header("location: index.php");
    exit;
}
?>

<?php include 'connection.php'; ?>
<?php

$username=$connection -> real_escape_string(($_POST['username']));
$userpass=$connection -> real_escape_string(($_POST['password']));



//----------------------------------------------------------------------------------------------
$s="SELECT username FROM users WHERE username='$username'";
$valid=(mysqli_query($connection, $s));
$validmember=(mysqli_fetch_array($valid));

if(!$validmember){
	
	$_SESSION['logged']=false;
	
echo "<script language='javascript' type='text/javascript'>";
echo "alert('Username not Found! Please try again.');";
echo "</script>";
$URL="loginregister.php";
echo "<script>location.href='$URL'</script>";

}else{
	//$_SESSION['logged']===true;
$s1="SELECT * FROM users WHERE username='$username'";
$valid1=(mysqli_query($connection, $s1));
if($valid1->num_rows>0){
while($row1=mysqli_fetch_array($valid1)){
	$currentuser=$row1['username'];
	$currentuserID=$row1['userID'];
	$admincode=$row1['admin'];
	$_SESSION['username']=$currentuser;
	$_SESSION['userID']=$currentuserID;
	$_SESSION['admincode']=$admincode;
	
	
}

$sql="SELECT pass FROM users WHERE username='$username'";
$pass=(mysqli_query($connection, $sql));

if($pass->num_rows>0){
while($row=mysqli_fetch_array($pass)){
	$passresult=$row['pass'];
	//$_SESSION['password']=$passresult;
}

//mysql_result($result, 0);

if (password_verify($userpass, $passresult)) {

	$_SESSION['logged']=true;
	$_SESSION['username']=$_SESSION['username'];
	$_SESSION['userID'] = $_SESSION['userID'];

	// Insert a new session upon login
	$sessionID = uniqid(); // Generate a unique session ID
	$userID = $_SESSION['userID']; // Replace with the logged-in user's ID
	$deviceInfo = $_SERVER['HTTP_USER_AGENT']; // Capture device information
	$insertSessionQuery = "INSERT INTO sessions (session_id, user_id, device_info, last_activity) VALUES ('$sessionID', $userID, '$deviceInfo', NOW())";
	$connection->query($insertSessionQuery);

	$_SESSION['session_id'] = $sessionID;
	$_SESSION['deviceInfo'] = $deviceInfo;

	echo "<script language='javascript' type='text/javascript'>";
	echo "alert('Login Successful!');";
	echo "</script>";
	$URL="index.php";
	echo "<script>location.href='$URL'</script>";

}else{
	
	$_SESSION["logged"]=false;
	
echo "<script language='javascript' type='text/javascript'>";
echo "alert('Incorrect Password! Please try again.');";
echo "</script>";
$URL="loginregister.php";
echo "<script>location.href='$URL'</script>";
}

}

}

}

//-----------------------------------------------------------------------------------------------



?>

