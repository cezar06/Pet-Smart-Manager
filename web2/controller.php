<?php
session_start();
require __DIR__ . '/usermodel.php';

    if (credentialsExist($_REQUEST['username'], $_REQUEST['password'])){
        echo '<script>
        window.location.replace("./index.php");
        </script>';
    }
    else{
        $_SESSION['fail_to_login'] = '1';
        echo '<script>
        window.location.replace("./index.php");
        </script>';
    }
    require 'view.php';
?>