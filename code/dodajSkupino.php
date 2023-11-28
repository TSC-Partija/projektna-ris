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
        <title>Ustvarjanje skupine</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <div class="main-div">
            <h1>Ustvarjanje skupine</h1>
            <form method="post" action="addGroup.php">
                <label for="name">Ime skupine:</label>
                <input type="text" id="name" name="name" maxlength="25"><br><br>
                <button type="submit">USTVARI</button>
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