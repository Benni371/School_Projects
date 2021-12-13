<?php
// ./actions/login_action.php

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
if(isset($_POST["submit"])){
	$name = $_POST["uname"];
	$pwd = $_POST["pword"];

	require_once "functions.php";
	if(emptyInputLogin($name, $pwd) !== false){
		header("location: ../views/login.php?error=emptyinput");
		exit();
	}
	loginUser($conn, $name, $pwd);

}
else{
	header("location: ../views/login.php");
}
?>