<?php
session_start();

//connect to sqlite
$pdo = new PDO('sqlite:database.db');
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['text'];
//using a prepared statement to prevent sql injection, insert into table feedback
$statement = $pdo->prepare(
    "INSERT INTO feedback (name, email, comment) VALUES (:name, :email, :comment)"
);
//execute the statement
$statement->execute(array(
    ':name' => $name,
    ':email' => $email,
    ':comment' => $comment
));
//redirect to index.php
echo "succes";
?>