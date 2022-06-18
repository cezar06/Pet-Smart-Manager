<?php
//session_start();
function credentialsExist($user, $pass){
    /*function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }*/

        $pdo = new PDO('sqlite:database.db');
        $statement = $pdo->prepare(
            "SELECT * FROM Users"
        );
        
        $statement->execute();
        
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            if ($row['username'] === $user && password_verify($pass, $row['password']))
            return true;
        }
     return false;
}
?>
