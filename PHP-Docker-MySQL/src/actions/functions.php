<?php

function emptyInputSignup($name, $pwd, $pwdrpt){
    if(empty($name) || empty($pwd) || empty($pwdrpt)){
    $result = true;
    return $result;
    }
    else{
        $result = false;
        return $result;
    }
    

}

function emptyInputLogin($name, $pwd){
    if(empty($name) || empty($pwd)){
    $result = true;
    return $result;
    }
    else{
        $result = false;
        return $result;
    }
    

}

function invalidUsername($name){
    $result = true;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $name)){
    
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;

}

function usernameExists($conn,$name){

    $sql = "SELECT * FROM `user` WHERE `username` = ?";
    if(!$stmt = $conn->prepare($sql)){
        header("location: ../views/register.php?error=badstmt1");
        exit();    
    }
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    $stmt->close();
}
function pwdMatch($pwd, $pwdrpt){
        $result = true;
        if($pwd !== $pwdrpt){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
}

function createUser($conn,$name,$pwd){

    $sql = "INSERT INTO `user` (username, password, logged_in) VALUES (?,?,?)";
    if(!$stmt = $conn->prepare($sql)){
		header("location: ../views/register.php?error=badstmt2");
        exit();
    }
    $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $logged_in = true;
    $stmt->bind_param("ssi", $name, $hashPwd, $logged_in);
    $stmt->execute();
    $stmt->close();
    header("location: ../index.php");
}

function loginUser($conn, $username, $pwd){
    $unameValid = usernameExists($conn, $username);

    if($unameValid === false)
    {
        header("location: ../views/login.php?error=wrongLogin1");
        exit();
    }

    $pwdHashed = $unameValid["password"];
    
    $checkPwd = password_verify($pwd, $pwdHashed);
    if($checkPwd === false){
        header("location: ../views/login.php?error=wrongLogin2");
        exit();
    }
    else if($checkPwd === true){
        $sql = "UPDATE `user` SET logged_in = 1 WHERE `username` = ?";
        if(!$stmt = $conn->prepare($sql)){
            header("location: ../views/register.php?error=badstmt2");
            exit();
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();
        session_start();
        $_SESSION["id"] = $unameValid["id"];
        $_SESSION["uname"] = $unameValid["username"];
        $_SESSION["logged_in"] = 1;

        header("location: ../index.php");
        exit();
    }

}

function createTask($conn, $text, $date, $name, $user_id)
{
    $sql = "INSERT INTO `task` (user_id, text, date, done) VALUES (?,?,?,?)";
    if(!$stmt = $conn->prepare($sql)){
		header("location: ../views/register.php?error=badstmt2");
        exit();
    }
    $done = false;
    $stmt->bind_param("issi", $user_id,$text,$date, $done);
    $stmt->execute();
    $stmt->close();

    header("location: ../index.php?status=taskAdded");
}
function readTasks($conn, $name, $id)
{   

    $sql = "Select * FROM `task` WHERE `user_id` = ?";
    if(!$stmt = $conn->prepare($sql)){
    header("location: ./index.php?error=badstmt2");
        exit();
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $string = "";
    if($result === NULL){
        return $string;
    }
    while($row = $result->fetch_assoc()){
          if($row["done"] === 1){
          $string .=  "<li class=\"task\"><span class=\"task-done material-icon\"><form action=\"./actions/update_action.php\" method=\"POST\"><input name=\"taskID\" class=\"hideBtn\" value=\"".$row["id"]."\"></input><button class=\"task-done material-icon checkbox-icon\">check_box</button></form></span><span><label class=\"task-description completed\" for=\"chkbx1\">" .$row["text"] ."</label><label class=\"task-date completed\">".$row["date"] ."</label><label class=\"task-delete material-icon\"><form class=\"none\" action=\"./actions/delete_action.php\" method=\"POST\"><input name=\"taskID\" class=\"hideBtn\" value=\"".$row["id"]."\"><button class=\"task-delete material-icon\">remove_circle</button></input></form></label>";

        }
        else{
          $string .=  "<li class=\"task\"><span class=\"task-done material-icon\"><form action=\"./actions/update_action.php\" method=\"POST\"><input name=\"taskID\" class=\"hideBtn\" value=\"".$row["id"]."\"></input><button class=\"task-done material-icon checkbox-icon\">check_box_outline_blank</button></form></span><label class=\"task-description\" for=\"chkbx1\">" .$row["text"] ."</label><label class=\"task-date\">".$row["date"] ."</label><label class=\"task-delete material-icon\"><form class=\"none\" action=\"./actions/delete_action.php\" method=\"POST\"><button class=\"task-delete material-icon\">remove_circle</button></input><input name=\"taskID\" class=\"hideBtn\" value=\"".$row["id"]."\"></input></form></label>";
        }
        }
    return $string;
    $stmt->close();
    
}