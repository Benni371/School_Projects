<?php
// ./actions/logout_action.php

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = "UPDATE `user` SET logged_in = 0 WHERE `username` = ?";
if(!$stmt = $conn->prepare($sql)){
	header("location: ../views/register.php?error=badstmt1");
	exit();    
}
session_start();
$username = $_SESSION["uname"];
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->close();

session_unset();
session_destroy();

header("location: ../views/login.php");
exit();

// TODO: Log the user out

?>
