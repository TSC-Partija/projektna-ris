<?php
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    // Read the request data from the input stream
    $input = file_get_contents('php://input');

    // Convert the JSON string to a PHP object
    $data = json_decode($input);
    $finished = $data->finished;
    $id = $data->id;
    $id = intval($id);

    $json = file_get_contents('db.json');
    $data = json_decode($json);

    $toDo = null;
    foreach ($data->toDos as $td) {
        if ($td->id == $id) {
            $toDo = $td;
            break;
        }
    }
    if ($toDo != null) {
        // Update the finished attribute of the toDo object
        $toDo->finished = $finished;
    
        // Encode the updated data as a JSON string
        $json = json_encode($data, JSON_PRETTY_PRINT);
        echo("update successful!");
    
        // Write the updated data back to the file
        file_put_contents('db.json', $json);
    }
?>