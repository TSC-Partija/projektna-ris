<?php
session_start();
if(isset($_POST["username"]) && $_POST["username"] != "" && $_POST["username"] != $_SESSION["username"]){
    $json_string = file_get_contents('db.json');
    $data = json_decode($json_string);
    foreach ($data->users as $user) {
        if($user->username == $_POST["username"]){
            // Update the finished attribute of the toDo object
            $user->groupIds[] = intval($_POST["groups"]);
        
            // Encode the updated data as a JSON string
            $json = json_encode($data, JSON_PRETTY_PRINT);
        
            // Write the updated data back to the file
            file_put_contents('db.json', $json);
            header('Location: dodajvskupino.php?error=Dodajanje%20uporabnika%20v%20skupino%20je%20uspešno!');
            exit;
        }
    }
    header('Location: dodajvskupino.php?error=Uporabnik%20ni%20najden!%20');
    exit;
}
else{
    header("Location: dodajvskupino.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
    exit;
}
?>
