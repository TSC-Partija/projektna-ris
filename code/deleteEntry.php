<?php
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    if($_SESSION['username'] != "guest"){
        // Read the request data from the input stream
        $input = file_get_contents('php://input');

        // Convert the JSON string to a PHP object
        $data = json_decode($input);
        $id = $data->id;
        $id = intval($id);

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
        /*
        $sql = "SELECT todo_group.name, todo_group.id as groupid, todo.id, todo.todo, todo.finished, todo.deadline FROM `pripada` inner join todo_group on (pripada.group_id = todo_group.id) inner join todo on (todo_group.id = todo.group_id) where user_id = \"" . $_SESSION['id'] . "\"";
        $result = $conn->query($sql);*/
        $sql = "delete from todo where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $stmt->close();
        $conn->close();
    }
?>