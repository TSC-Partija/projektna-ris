<?php
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    // Read the request data from the input stream
    if($_SESSION['username'] != "guest"){
        $input = file_get_contents('php://input');

        // Convert the JSON string to a PHP object
        $data = json_decode($input);
        $finished = intval($data->finished);
        $id = $data->id;
        $id = intval($id);

        $servername = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "todolist";
        // Create a new MySQLi object
        $conn = new mysqli($servername, $user, $pass, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the update query
        $stmt = $conn->prepare("UPDATE todo SET finished = ? WHERE id = ?");
        $stmt->bind_param("ii", $fin, $id);

        // Set the values of the parameters
        $fin = $finished;

        // Execute the query
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
?>