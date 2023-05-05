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
        <title>Dodajanje v skupino</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <div class="main-div">
            <h1>Dodajanje uporabnikov v skupino</h1>
            <form method="post" action="checkuser.php">
                <label for="groups">Ime skupine:</label>
                <select id="groups" name="groups">

                    <?php

                        $json_string = file_get_contents('db.json');
                        $data = json_decode($json_string, true);
                        foreach ($data['groups'] as $groups) {
                            if(($_SESSION["id"]) == $groups["owner"]){
                                echo "<option value=" . $groups["id"] . " id=\"" . $groups["id"] . "\"" . ">" . $groups['name'] . "</option>";
                            }
                        }

                    ?>

                </select>
                <br>
                <label for="username">Uporabnik:</label>
                <input type="text" id="username" name="username"><br><br>
                <button type="submit">DODAJ</button>
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