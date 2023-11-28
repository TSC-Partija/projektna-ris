<?php
$sess_expiration = 900;
session_set_cookie_params($sess_expiration);
ini_set('session.gc_maxlifetime', $sess_expiration);
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.php");
    exit;
}
if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
    // If the session has expired, destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// Reset the session expiration time on user activity
$_SESSION['expire_time'] = time() + $sess_expiration;
?>

<!DOCTYPE html>
<head>
    <title>Moja Opravila</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet">
    <style>
        *{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f44336;
            padding: 10px;
            color: white;
            text-decoration: none;
            text-align: center;
            }
        a.footer:hover{
            background-color: #f44300;
        }
    </style>
</head>

<div id="myDIV" class="header">
    <?php if($_SESSION['username'] != "guest"): ?>
    <div id="options-button">|||</div>
        <div id="options-window">
        <h2 id="options">NASTAVITVE</h2>
        <hr/>
        <a href="dodajSkupino.php"><p id="skupina" class="nastavitve">Ustvari skupino</p></a>
        <a href="dodajvskupino.php"><p id="dodajskupina" class="nastavitve">Dodaj v skupino</p></a>
        <a href="changePass.php"><p id="spremenigeslo" class="nastavitve">Spremeni geslo</p></a>
        </div>
    <?php endif; ?>
    <h2 style="margin:5px;">Moja Opravila</h2>
    <?php if($_SESSION['username'] != "guest"): ?>
        <input type="text" id="todo" placeholder="Naslov..." maxlength="60">
        <br>
        <select id="groups">

            <?php

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
                $id = $_SESSION['id'];
                /*
                $sql = "SELECT `group_id`, `name` FROM `todo_group` inner join pripada on (pripada.group_id = todo_group.id) where user_id = $id;";
                $result = $conn->query($sql);*/
                $stmt = $conn->prepare("SELECT `group_id`, `name` FROM `todo_group` inner join pripada on (pripada.group_id = todo_group.id) where user_id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                        foreach($_SESSION['groupIds'] as $group){
                            if($group == $row['group_id']){
                                echo "<option value=\"" . $group . "\" id=\"" . $group . "\">" . $row['name'] . "</option>";
                            }
                        }
                    }
                }
                $stmt->close();
                $conn->close();
                //echo "<option value=" . $value1 . " id=" . $value1 . ">" . $groups['name'] . "</option>";

            ?>

        </select>
        <input type="date" id="date" placeholder="deadline">
    <span onclick="newElement()" class="addBtn">Dodaj</span>
    <?php
        if(isset($_SESSION['error'])){
            echo("<p style=\"color: red; background-color: white; width: max-content\">Vnesi vse podatke!</p>");
            unset($_SESSION['error']);
        }
        ?>
    <?php endif; ?>
</div>

<ul id="myUL">

    <?php

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
    $sql = "SELECT todo_group.name, todo_group.id as groupid, todo.id, todo.todo, todo.finished, todo.deadline FROM `pripada` inner join todo_group on (pripada.group_id = todo_group.id) inner join todo on (todo_group.id = todo.group_id) where user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            //var_dump($_SESSION['groupIds']);
            foreach($_SESSION['groupIds'] as $group){
                if(true == $row['finished'] && $group == $row['groupid']){
                    echo "<li id=\"" . $row['id'] . "\" class=checked><b style=\"text-transform: uppercase;\">" . $row['todo'] . "</b>&nbsp&nbspSkupina: " . $row['name'] . "&nbsp&nbspKončaj do: " . $row['deadline'] . "</li>";
                }
                else if(false == $row['finished'] && $group == $row['groupid']){
                    echo "<li id=\"" . $row['id'] . "\"><b style=\"text-transform: uppercase;\">" . $row['todo'] . "</b>&nbsp&nbspSkupina: " . $row['name'] . "&nbsp&nbspKončaj do: " . $row['deadline'] . "</li>";
                }
            }
        }
    }
    $conn->close();
    //SELECT todo_group.name, todo.todo, todo.finished, todo.deadline FROM `pripada` inner join todo_group on (pripada.group_id = todo_group.id) inner join vsebuje on (vsebuje.group_id = todo_group.id) inner join todo on (vsebuje.todo_id = todo.id) where user_id = 1;

    ?>
</ul>

<h7 class="footer" style="margin-bottom: 35px" name="<?= $_SESSION['username'] ?>">Prijavljen kot: <?= $_SESSION['username'] ?></h7>
<a class="footer" href="logout.php">ODJAVA</a>
<script src="script.js"></script>
