<?php
// ./actions/register_action.php

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
if(isset($_POST["Reg"])){
	$name = $_POST["RegUname"];
	$pwd = $_POST["RegPword"];
	$pwdrpt = $_POST["RegPword2"];
	
	require_once './functions.php';
	// fields empty
	if(emptyInputSignup($name, $pwd, $pwdrpt) !== false){
		header("location: ../views/register.php?error=emptyinput");
		exit();
	}
	if(invalidUsername($name) !== false){
		header("location: ../views/register.php?error=invalidUsername");
		exit();
	}
	if(pwdMatch($pwd, $pwdrpt) !== false){
		header("location: ../views/register.php?error=pwdNoMatch");
		exit();
	}
	if(usernameExists($conn, $name) !== false){
		header("location: ../views/register.php?error=usernameTaken");
		exit();
	}

	createUser($conn, $name, $pwd);
	loginUser($conn, $name, $pwd);

}
else{

	header("location: ../views/register.php");
	exit();
}
?>
