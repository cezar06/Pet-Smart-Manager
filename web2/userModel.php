<?php
function credentialsExist($user, $pass){
    /*function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }*/

    $pdo = new PDO('sqlite:database.db');
    $statement = $pdo->query('SELECT * FROM Users');
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        if ($row['username'] === $user && $row['password'] === $pass)
            return true;
     }
     return false;
}

?>