<?php
// Start the session
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sprememba gesla</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <div class="main-div">
            <h1>Sprememba gesla</h1>
            <form method="post" action="chngpass.php">
                <label for="password">Novo geslo:</label>
                <input type="password" id="password" name="password"><br><br>
                <button type="submit">SPREMENI</button>
            </form>
            <form action="view.php">
                <button type="submit" style="margin-top: 10px">NAZAJ</button>
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
        </div>
    </body>
</html>