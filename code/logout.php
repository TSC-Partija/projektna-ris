<?php
session_start();
session_destroy(); // destroy all session data

// Redirect to the login page
header("Location: index.php");
exit;
?>