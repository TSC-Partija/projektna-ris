<?php
    // Start a session to store the user's information
    $sess_expiration = 900;
    session_set_cookie_params($sess_expiration);
    ini_set('session.gc_maxlifetime', $sess_expiration);
    session_start();
    //$_SESSION['expire_time'] = time() + $sess_expiration;
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($password) && $password != "" && isset($username) && $username != "") {
        // Get the user's credentials from the form
        
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
    header("Location: index.php?error=Vnesi%20vse%20podatke!");
    exit;

    function authenticate($username, $password){
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
        $sql = "SELECT username, id, email, password FROM user where username = '$username' and BINARY password = \"" . $password . "\";";
        $result = $conn->query($sql);
        echo $result->num_rows;
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
        $conn->close();
    }

    function getUserData($username, $password){
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
        $sql = "SELECT username, id, email, password, group_id FROM user inner join pripada on (user.id = pripada.user_id) where username = \"" . $username . "\" and password = \"" . $password . "\";";
        $result = $conn->query($sql);
        echo $result->num_rows;
        if($result->num_rows > 0){
            $user = null;
            while($row = $result->fetch_assoc()) {
                $user = new User($row['id'], $row['username'], $row['email'], $row['password']);
            }
        }
        $sql = "SELECT username, id, email, password, group_id FROM user inner join pripada on (user.id = pripada.user_id) where username = \"" . $username . "\" and password = \"" . $password . "\";";
        $result = $conn->query($sql);
        echo $result->num_rows;
        if($result->num_rows > 0){
            $groupIds = [];
            while($row = $result->fetch_assoc()) {
                $groupIds[] = $row["group_id"];
            }
        }
        $user->setGroupIds($groupIds);
        $conn->close();
        return $user;
    }

    class User {
        public $id;
        public $username;
        public $email;
        public $password;
        public $groupIds = [];
        
        function __construct($id, $username, $email, $password) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
        }
        function setGroupIds($groupIds) {
            $this->groupIds = $groupIds;
        }
    }
?>
