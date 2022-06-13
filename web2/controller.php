<?php
require __DIR__ . '/usermodel.php';

    if (credentialsExist($_REQUEST['username'], $_REQUEST['password'])){
        $message='Login true';
    }
    else
    $message='Login false';
    require 'view.php';
?>