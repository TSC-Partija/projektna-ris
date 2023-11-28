<?php
    if($_POST["name"] != ""){
        $sess_expiration = 900;
        session_set_cookie_params($sess_expiration);
        ini_set('session.gc_maxlifetime', $sess_expiration);
        session_start();

        $name = $_POST['name'];
        $owner = $_SESSION["id"];
        $id = rand(785, 155555);

        // Create a new MySQLi object
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
        $stmt = "INSERT INTO todo_group (id, owner, name) VALUES ($id, $owner, \"$name\")";

        // Execute the query
        mysqli_query($conn, $stmt);

        // Close the statement and connection
        $conn->close();

        $conn = new mysqli($servername, $user, $pass, $dbname);

        // Check connection
        if ($conn->connect_error) {
            header("Location: view.php?error=Error:%20Connection%20failed:%20" . $conn->connect_error);
            exit();
        }
        $user_id = $_SESSION['id'];
        $stmt = "INSERT INTO pripada (user_id, group_id) VALUES ($user_id, $id)";

        // Execute the query
        mysqli_query($conn, $stmt);

        // Close the statement and connection
        $conn->close();

        $user_data = getUserData($_SESSION["username"]);
        $_SESSION["groupIds"] = $user_data->groupIds;
        header('Location: index.php?error=Dodajanje%20skupine%20je%20uspešno!');
        exit;
    }
    else{
        header("Location: dodajSkupino.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
        exit;
    }
    function getUserData($username){
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
        $sql = "SELECT username, id, email, password, group_id FROM user inner join pripada on (user.id = pripada.user_id) where username = \"" . $username . "\";";
        $result = $conn->query($sql);
        echo $result->num_rows;
        if($result->num_rows > 0){
            $user = null;
            while($row = $result->fetch_assoc()) {
                $user = new User($row['id'], $row['username'], $row['email'], $row['password']);
            }
        }
        $sql = "SELECT username, id, email, password, group_id FROM user inner join pripada on (user.id = pripada.user_id) where username = \"" . $username . "\";";
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