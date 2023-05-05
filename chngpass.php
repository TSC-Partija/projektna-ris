<?php
session_start();
function change(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the user's credentials from the form
        $password = $_POST['password'];

        // Check if the credentials are valid
        if (isset($password) && $password != "") {
            // TODO: adding a new user to the database

            $json = file_get_contents('db.json');
            $data = json_decode($json);

            $user_id = $_SESSION["id"];
            $user = null;
            foreach ($data->users as &$u) {
                if ($u->id == $user_id) {
                    $user = &$u;
                    break;
                }
            }

            if ($user != null) {
                // Update the user's password
                $user->password = $password;

                // Save the updated user information
                file_put_contents('db.json', json_encode($data, JSON_PRETTY_PRINT));
            }

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
