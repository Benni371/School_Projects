<?php 
include_once 'functions.php';
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
session_start();

$name = $_SESSION["uname"];
$text = $_POST["txt"];
$date = $_POST["date"];
$id = $_SESSION["id"];


if(!isset($text)){
    header("location: ../index.php?error=emptyText");
    exit();
}
if(!isset($date)){
    header("location: ../index.php?error=emptyDate");
    exit();
}
createTask($conn, $text, $date, $name, $id);
exit();



?>