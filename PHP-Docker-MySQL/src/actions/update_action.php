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
$id = $_POST["taskID"];
$grabSQL = "SELECT `done` FROM `task` WHERE `task`.`id` = ?";
if(!$stmt = $conn->prepare($grabSQL)){
    header("location: ../views/register.php?error=badstmt2");
    exit();
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if($row["done"] === 1){
    $sql = "UPDATE `task` SET `done` = '0' WHERE `task`.`id` = ?";
    if(!$stmt = $conn->prepare($sql)){
        header("location: ../views/register.php?error=badstmt2");
        exit();
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
else{
    $sql = "UPDATE `task` SET `done` = '1' WHERE `task`.`id` = ?";

    if(!$stmt = $conn->prepare($sql)){
        header("location: ../views/register.php?error=badstmt2");
        exit();
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    }
header("location: ../index.php?status=updated");
exit();