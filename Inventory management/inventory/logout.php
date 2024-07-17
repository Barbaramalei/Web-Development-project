<?php
// Initialize the session
session_start();
$sessionID = $_SESSION['session_id'];
$userID = $_SESSION['userID'];
$deviceInfo = $_SESSION['deviceInfo'];

include 'connection.php';

// Logout from all devices
$getCurrentSessionQuery = "SELECT session_id FROM sessions WHERE user_id = $userID AND device_info = '$deviceInfo'";
$currentSessionResult = $connection->query($getCurrentSessionQuery);
$currentSessionRow = $currentSessionResult->fetch_assoc();
$currentSessionID = $currentSessionRow['session_id'];

$deleteSessionsQuery = "DELETE FROM sessions WHERE user_id = $userID";
$connection->query($deleteSessionsQuery);

// Unset all of the session variables
$_SESSION = array();
 
 //Unset session variables
 session_unset();
 
// Destroy the session.
session_destroy();

// Redirect to login page
header("location: loginregister.php");
exit;
?>