<?php

    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();

    // Read the request data from the input stream
    $input = file_get_contents('php://input');

    // Convert the JSON string to a PHP object
    $data = json_decode($input);

    // Access the data fields
    $toDo = $data->toDo;
    $groupId = $data->groupId;
    $deadline = $data->deadline;

    // Do something with the data...
    $json = file_get_contents('db.json');
    $data = json_decode($json);

    $newToDo = new stdClass();
    $newToDo->id = ++$data->toDoIdCounter;  // Increment the ToDo ID counter
    $newToDo->owner = $_SESSION['id'];  // Set the owner ID
    if($groupId == ""){
        $newToDo->groupIds = [];  // Set the group IDs
    }
    else{
        $newToDo->groupIds = [intval($groupId)];  // Set the group IDs
    }
    $newToDo->toDo = $toDo;
    $newToDo->finished = false;
    $newToDo->deadline = $deadline;

    $data->toDos[] = $newToDo;
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents('db.json', $json);
?>