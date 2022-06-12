<?php
$uName = 'admin';
$sName = $_POST['txtName'];
$sId = bin2hex(random_bytes(16));
try{
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRORMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $stmt = $db->prepare('INSERT INTO pets VALUES (:username, :petname)');
    $stmt->bindValue(':username', $uName);
    $stmt->bindValue(':petname', $sName);
    $stmt->execute();
    echo '{id: "' . $sId . '"}';
}
catch(PDOException $ex){
    echo'{"status":0}';
    exit;
}
