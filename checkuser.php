<?php
    if(isset($_POST["username"]) && $_POST["username"] != ""){
        $json_string = file_get_contents('db.json');
        $data = json_decode($json_string, true);
        foreach ($data['users'] as $users) {
            if($_POST["username"] == $users["username"]){
                $user_id = $users["id"];
                $user = null;
                foreach ($data["users"] as &$u) {
                    if ($u->id == $user_id) {
                        $user = &$u;
                        break;
                    }
                }

                $group_id = null;
                foreach ($data['groups'] as $groups) {
                    if ($groups['name'] == $_POST["groups"]) {
                        $group_id = $groups['id'];
                        $group_id = intval($group_id);
                        break;
                    }
                }

                if ($user != null && $group_id != null) {
                    // Update the user's password
                    $user->groupIds[] = $group_id;

                    // Save the updated user information
                    file_put_contents('db.json', json_encode($data, JSON_PRETTY_PRINT));
                }

                // Redirect the user to the home page
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