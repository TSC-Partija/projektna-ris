<?php

// Start the session
$sess_expiration = 900;
session_set_cookie_params($sess_expiration);
ini_set('session.gc_maxlifetime', $sess_expiration);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: view.php?error=Error:%20User%20not%20logged%20in");
    exit();
}

// Read the request data from the input stream
$input = file_get_contents('php://input');

// Convert the JSON string to a PHP object
$data = json_decode($input);

// Check if the JSON decoding was successful
if ($data === null) {
    header("Location: view.php?error=Error:%20Invalid%20input%20data");
    exit();
}

// Access the data fields
$todo = $data->toDo;
$groupId = $data->groupId;
$deadline = $data->deadline;
$owner = intval($_SESSION['id']);
$finished = 0;

if(isset($todo) && $todo != "" && isset($groupId) && $groupId != "" && isset($deadline) && $deadline != "" && $owner != "" && isset($finished) && $finished != ""){
    // Create a new MySQLi object
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "todolist";
    $conn = new mysqli($servername, $user, $pass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        header("Location: view.php?error=Error:%20Connection%20failed:%20" . $conn->connect_error);
        exit();
    }

    // Prepare and bind the insert query

    $groupId = intval($groupId);
    $stmt = "INSERT INTO todo (owner, todo, finished, deadline, group_id) VALUES ($owner, \"$todo\", $finished, \"$deadline\", $groupId)";


    // Execute the query
    mysqli_query($conn, $stmt);

    // Close the statement and connection
    $conn->close();
}
else{
    $_SESSION['error'] = "Vneseni niso vsi podatki!";
}

?>
