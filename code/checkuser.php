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

if($_POST["username"] == $_SESSION["username"]){
    header("Location: dodajvskupino.php?error=Samega%20sebe%20neupaš%20dodajat%20v%20skupino!");
    exit;
}

if(isset($_POST["username"]) && $_POST["username"] != ""){
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

    $username = $_POST['username'];
    $sql = "SELECT username, id from user where username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    echo $result->num_rows;

    $conn = new mysqli($servername, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo mysqli_error($conn);
        exit;
    }

    $username = $_POST['username'];
    $group = $_POST['groups'];
    $sql = "SELECT user_id from pripada inner join user on(user.id = pripada.user_id) where user.username = ? and pripada.group_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $group);
    $stmt->execute();
    $rez = $stmt->get_result();
    $conn->close();
    $stmt->close();

    if($rez->num_rows > 0){
        header("Location: dodajvskupino.php?error=Uporabnik%20je%20že%20del%20te%20skupine!");
        exit;
    }

    if($result->num_rows > 0){
        $id = null;
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }

        $conn = new mysqli($servername, $user, $pass, $dbname);

        if ($conn->connect_error) {
            header("Location: dodajvskupino.php?error=Error:%20Connection%20failed:%20" . $conn->connect_error);
            exit;
        }

        $group_id = $_POST['groups'];
        $stmt = $conn->prepare("INSERT INTO pripada (user_id, group_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $id, $group_id);
        $stmt->execute();

        $conn->close();
        header('Location: dodajvskupino.php?error=Dodajanje%20uporabnika%20v%20skupino%20je%20uspešno!');
        exit;
    }
    header('Location: dodajvskupino.php?error=Uporabnik%20ni%20najden!%20');
    exit;
}
else{
    header("Location: dodajvskupino.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
    exit;
}
?>