<?php
$sess_expiration = 900;
session_set_cookie_params($sess_expiration);
ini_set('session.gc_maxlifetime', $sess_expiration);
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
    // If the session has expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

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

                        $servername = "localhost";
                        $user = "root";
                        $pass = "";
                        $dbname = "todolist";

                        $conn = new mysqli($servername, $user, $pass, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            echo mysqli_error($conn);
                            exit;
                        }
                        $id = $_SESSION['id'];
                        $sql = "select name, id from todo_group where owner = $id;";
                        $result = $conn->query($sql);
                        echo $result->num_rows;
                        if($result->num_rows > 0){
                            $user = null;
                            while($row = $result->fetch_assoc()) {
                                echo "<option value=" . $row["id"] . " id=\"" . $row["id"] . "\"" . ">" . $row['name'] . "</option>";
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