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
    <h2 style="margin:5px;">Moja Opravila</h2>
    
        <input type="text" id="todo" placeholder="Naslov...">
        <br>
        <select id="groups">
            <option value="" id="nogroup">Brez skupine</option>

            <?php

                $json_string = file_get_contents('db.json');
                $data = json_decode($json_string, true);
                foreach ($data['groups'] as $groups) {
                    foreach ($_SESSION['groupIds'] as $value1) {
                        if($groups['id'] == $value1){
                            echo "<option value=" . $value1 . " id=" . $value1 . ">" . $groups['name'] . "</option>";
                        }
                    }
                }

            ?>

        </select>
        <input type="date" id="date" placeholder="deadline">
    <span onclick="newElement()" class="addBtn">Dodaj</span>
</div>

<ul id="myUL">

    <?php
        
    $json_string = file_get_contents('db.json');
    $data = json_decode($json_string, true);
    foreach ($data['toDos'] as $toDo) {
        if($_SESSION['id'] == $toDo['owner']){
            if($toDo['finished']){
                echo "<li id=\"" . $toDo['id'] . "\" class=checked><b style=\"text-transform: uppercase;\">" . $toDo['toDo'] . "</b>" . " Končaj do: " . $toDo['deadline'] . "</li>";
            }
            else{
                echo "<li id=\"" . $toDo['id'] . "\"><b style=\"text-transform: uppercase;\">" . $toDo['toDo'] . "</b>" . " Končaj do: " . $toDo['deadline'] . "</li>";
            }
        }
        else{
            foreach ($_SESSION['groupIds'] as $value1) {
                foreach ($toDo['groupIds'] as $value2) {
                    if ($value1 == $value2) { 
                        foreach($data['groups'] as $groups){
                            if($groups['id'] == $value1){
                                if($toDo['finished']){
                                    echo "<li id=\"" . $toDo['id'] . "\" class=checked><b style=\"text-transform: uppercase;\">" . $toDo['toDo'] . "</b>" . " Skupina: " . $groups['name'] . " Končaj do: " . $toDo['deadline'] . "</li>";
                                }
                                else{
                                    echo "<li id=\"" . $toDo['id'] . "\"><b style=\"text-transform: uppercase;\" >" . $toDo['toDo'] . "</b>" . " Skupina: " . $groups['name'] . " Končaj do: " . $toDo['deadline'] . "</li>";
                                }
                                    break 3;
                            }
                        }
                        if($toDo['finished']){
                            echo "<li id=\"" . $toDo['id'] . "\" class=checked><b style=\"text-transform: uppercase;\">" . $toDo['toDo'] . "</b>" . " Končaj do: " . $toDo['deadline'] . "</li>";
                        }
                        else{
                            echo "<li id=\"" . $toDo['id'] . "\"><b style=\"text-transform: uppercase;\">" . $toDo['toDo'] . "</b>" . " Končaj do: " . $toDo['deadline'] . "</li>";
                        }
                        break 2;
                    }
                }
            }
        }
    }

    ?>
</ul>
<h7 class="footer" style="margin-bottom: 35px">Prijavljen kot: <?= $_SESSION['username'] ?></h7>
<a class="footer" href="logout.php">ODJAVA</a>
<script src="script.js"></script>
