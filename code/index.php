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
        <title>Prijava</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <div class="main-div">
            <h1>Prijava</h1>
            <form method="post" action="login.php">
                <label for="username">Up. ime:</label>
                <input type="text" id="username" name="username"><br><br>
                <label for="password">Geslo:</label>
                <input type="password" id="password" name="password"><br><br>
                <button type="submit">PRIJAVA</button>
            </form>
            <form action="register.php">
                <button type="submit" style="margin-top: 10px">REGISTRIRAJ SE<SEct></SEct></button>
            </form>
            <form action="login.php" method="post">
                <button type="submit" style="margin-top: 10px">PRIJAVA BREZ REGISTRACIJE (kot gost)<SEct></SEct></button>
                <input type="hidden" id="username" name="username" value="guest">
                <input type="hidden" id="password" name="password" value="guest">
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
        </div>
    </body>
</html>