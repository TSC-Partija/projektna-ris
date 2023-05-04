<?php
    // Start a session to store the user's information
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    //$_SESSION['expire_time'] = time() + $sess_expiration;

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the user's credentials from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the credentials are valid
        if (authenticate($username, $password)) {
            // Store the user's information in the session
            $_SESSION['username'] = $username;
            $_SESSION['authenticated'] = true;
            $userData = getUserData($username, $password);
            $_SESSION['id'] = $userData->id;
            $_SESSION['email'] = $userData->email;
            $_SESSION['groupIds'] = $userData->groupIds;
            // Redirect the user to the home page
            header('Location: view.php');
            exit;
        } else {
            // Invalid credentials, show an error message
            header("Location: index.php?error=Napačni%20prijavni%20podatki!");
            exit;
        }
    }

    function authenticate($username, $password){
        $json_string = file_get_contents('db.json');
        $data = json_decode($json_string);
        foreach ($data->users as $user) {
            if ($user->username == $username && $user->password == $password) {
                return true;
            }
        }
        return false;
    }

    function getUserData($username, $password){
        $json_string = file_get_contents('db.json');
        $data = json_decode($json_string);
        foreach ($data->users as $user) {
            if ($user->username == $username && $user->password == $password) {
                return $user;
            }
        }
    }
?>
