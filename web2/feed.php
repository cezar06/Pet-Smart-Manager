<?php

$web_url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

$str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$str .= "<rss version=\"2.0\">\n";
$str .= "<channel>\n";
$str .= "<title> Pet feed </title>\n";
$str .= "<link> $web_url </link>\n";
$str .= "<description> Pet feed </description>\n";
$str .= "<language >en-US </language>\n";
//connect to sqlite database
$pdo = new PDO("sqlite:database.db");
//get all "text" from table Calendar where "type" is "Life Event" using a prepared statement
$stmt = $pdo->prepare("SELECT * FROM Calendar WHERE type = 'Life Event'");
$stmt->execute();
//loop through all rows in the result set
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $str .= "<item>\n";
    $str .= "<title>" . $row['text'] . "</title>\n";
    $str .= "<description>" . $row['text'] . "</description>\n";
    $str .= "<link>" . $web_url . "</link>\n";
    $str .= "</item>\n";
}
$str .= "</channel>\n";
$str .= "</rss>\n";
file_put_contents("rss.xml", $str);
?>
<a>
    <link rel="alternate" type="application/rss+xml" href="rss.xml" />
</a>