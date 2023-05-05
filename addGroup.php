<?php
    if($_POST["name"] != ""){
        $sess_expiration = 900;
        session_set_cookie_params($sess_expiration);
        ini_set('session.gc_maxlifetime', $sess_expiration);
        session_start();

        // Do something with the data...
        $json = file_get_contents('db.json');
        $data = json_decode($json);

        $newGroup = new stdClass();
        $newGroup->id = ++$data->groupIdCounter;
        $newGroup->name = $_POST['name'];
        $newGroup->owner = $_SESSION["id"];

        $data->groups[] = $newGroup;
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('db.json', $json);

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
            $user->groupIds[] = $newGroup->id;

            // Save the updated user information
            file_put_contents('db.json', json_encode($data, JSON_PRETTY_PRINT));
        }

        $user_data = getUserData($_SESSION["username"]);
        $_SESSION["groupIds"] = $user_data->groupIds;
        header('Location: dodajSkupino.php?error=Dodajanje%20skupine%20je%20uspešno!');
        exit;
    }
    else{
        header("Location: dodajSkupino.php?error=Vneseni%20niso%20bili%20vsi%20podatki!");
        exit;
    }
    function getUserData($username){
        $json_string = file_get_contents('db.json');
        $data = json_decode($json_string);
        foreach ($data->users as $user) {
            if ($user->username == $username) {
                return $user;
            }
        }
    }
?>