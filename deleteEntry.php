<?php
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    // Read the request data from the input stream
    $input = file_get_contents('php://input');

    // Convert the JSON string to a PHP object
    $data = json_decode($input);
    $id = $data->id;
    $id = intval($id);

    $json = file_get_contents('db.json');
    $data = json_decode($json);

    $toDoIndex = -1;
    foreach ($data->toDos as $index => $td) {
        if ($td->id == $id) {
            $toDoIndex = $index;
            break;
        }
    }
    if ($toDoIndex != -1) {
        // Remove the toDo object from the array
        array_splice($data->toDos, $toDoIndex, 1);
    
        // Encode the updated data as a JSON string
        $json = json_encode($data, JSON_PRETTY_PRINT);
        //echo("delete successful!");
    
        // Write the updated data back to the file
        file_put_contents('db.json', $json);
    }
?>