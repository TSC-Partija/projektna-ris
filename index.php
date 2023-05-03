<?php
// Start the session
session_start();

// Check if the user is authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
  // If the user is not authenticated, redirect them to the login page
  header('Location: view.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <h1>Login</h1>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p><?php echo $_GET['error']; ?></p>
        <?php endif; ?>
    </body>
</html>