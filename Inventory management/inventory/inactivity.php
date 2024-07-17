<link rel = "icon" href = "Images/studyhelp_icon.png" type = "image/x-icon">
<?php

// Set the inactivity timeout (in seconds)
$inactivityTimeout = 600; // 10 minutes

// Check if the user is logged in and there is a last activity time stored in the session
if (isset($_SESSION['logged']) && isset($_SESSION['last_activity'])) {
    // Calculate the time difference between the current time and the last activity time
    $inactiveTime = time() - $_SESSION['last_activity'];

    // Check if the inactive time exceeds the inactivity timeout
    if ($inactiveTime > $inactivityTimeout) {
        // Redirect to the logout page
        header('Location: logout.php');
        exit;
    }
}

?>