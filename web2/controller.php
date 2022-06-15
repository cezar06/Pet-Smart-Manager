<?php
session_start();
require __DIR__ . '/usermodel.php';

    if (credentialsExist($_REQUEST['username'], $_REQUEST['password'])){
        $_SESSION['logged_in_user_id'] = '1';
        $_SESSION['contor_login']++;
        echo '<script>
        window.location.replace("./index.php");
        </script>';
    }
    else{
        
        echo '<script>
        window.location.replace("./index.php");
        </script>';
    }
    require 'view.php';
?>