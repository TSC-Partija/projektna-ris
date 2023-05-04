<?php
function register(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the user's credentials from the form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Check if the credentials are valid
        if (isset($username) && $username != "" && isset($password) && $password != "" && isset($email) && $email != "") {
            // TODO: adding a new user to the database

            $json = file_get_contents('db.json');
            $data = json_decode($json);

            $newUser = new stdClass();
            $newUser->id = ++$data->userIdCounter;  // Increment the ToDo ID counter
            $newUser->username = $username;
            $newUser->password = $password;
            $newUser->email = $email;
            $newUser->groupIds = [];  // Set the group IDs

            $data->users[] = $newUser;
            $json = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents('db.json', $json);

            // Redirect the user to the home page
            header('Location: index.php?error=Registracija%20novega%20uporabnika%20uspešna!');
            exit;
        } else {
            // Invalid credentials, show an error message
            header("Location: register.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
            exit;
        }
    } 
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        register();
      }
?>