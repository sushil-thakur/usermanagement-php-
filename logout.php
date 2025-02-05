<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: index.php"); // Redirect to homepage or login page
exit();
?>
