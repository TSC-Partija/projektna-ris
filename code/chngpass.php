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
function change(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the user's credentials from the form
        $password = $_POST['password'];

        // Check if the credentials are valid
        if (isset($password) && $password != "") {
            $user_id = $_SESSION["id"];
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
            $stmt = $conn->prepare("UPDATE user SET password = BINARY ? WHERE id = ?");

            $stmt->bind_param("si", $password, $user_id);

            if ($stmt->execute()) {
                // Password updated successfully, redirect the user to the home page
                header('Location: changePass.php?error=Sprememba%20gesla%20je%20uspešna!');
                exit;
            } else {
                // An error occurred, show an error message
                echo "Error updating password: " . $conn->error;
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();

            // Redirect the user to the home page
            header('Location: changePass.php?error=Sprememba%20gesla%20je%20uspešna!');
            exit;
        } else {
            // Invalid credentials, show an error message
            header("Location: changePass.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
            exit;
        }
    } 
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    change();
}
?>
