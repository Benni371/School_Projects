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
$id = $_POST["taskID"];
$sql = "DELETE FROM `task` WHERE `id` = ?";
if(!$stmt = $conn->prepare($sql)){
    header("location: ../index.php?error=badstmt2");
    exit();
}
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("location: ../index.php?status=taskDeleted");
exit();




?>