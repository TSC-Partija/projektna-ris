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

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: register.php?error=%20Nepravilen%20email%20format!" . $conn->connect_error);
                exit();
            }

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
            $stmt = "select username from user where username = '$username'";
            $result = $conn->query($stmt);
                if($result->num_rows > 0){
                    header("Location: register.php?error=Uporabnik%20s%20tem%20imenom%20že%20obstaja!" . $conn->connect_error);
                    exit();
                }
            // Prepare and bind the insert query
            $id = rand(750, 255555);
            $stmt = "INSERT INTO user (id, username, email, password) VALUES ($id, '$username', '$email', '$password')";

            // Execute the query
            mysqli_query($conn, $stmt);

            //HARDCODED ID ZA SKUPINO!!!!
            $stmt = "INSERT INTO pripada (user_id, group_id) VALUES ($id, 24871)";

            // Execute the query
            mysqli_query($conn, $stmt);

            // Close the statement and connection
            $conn->close();

            // Redirect the user to the home page
            header('Location: register.php?error=Registracija%20novega%20uporabnika%20uspešna!');
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