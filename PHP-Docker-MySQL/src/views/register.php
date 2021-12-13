<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" type="image/jpg" href="../favicon.ico"/>

    <title>Register</title>
</head>
<body class="loginBody">
    
<h1 class="header">Register</h1>
<?php 
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Please fill in all fields</p>";
        }
        else if($_GET["error"] == "invalidUsername"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Username contains invalid characters!</p>";
        }
        else if($_GET["error"] == "pwdNoMatch"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Passwords did not match!</p>";
        }
        else if($_GET["error"] == "usernameTaken"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Sorry! This username ".$_GET["name"]." is taken</p>";
        }
        else if($_GET["error"] == "badstmt1"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Error in SQL query</p>";
        }
        else if($_GET["error"] == "badstmt2"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Error in SQL query</p>";
        }
        else{

        }
    }
?>
<form action="../actions/register_action.php" class="formTable" method="POST">
<p>    
    <label class="login" for="RegUname">Username:&nbsp;</label><input class="login" type="text" name="RegUname">
</p>
<br>
<p>
    <label class="login" for="RegPword">Password:&nbsp;</label><input class="login" type="password" name="RegPword" >
</p>
<br>
<p>
    <label class="login" for="RegPword2">Confirm Password:&nbsp;</label><input class="login" type="password" name="RegPword2">
</p>
<br>
<p>
<label for="">&nbsp;</label>    
<button class="btn longBtn" name="Reg">Register</button>
</p>
<br>
<p>
    <label for="">&nbsp;</label>Already have an account? <a href="./login.php">Sign in</a> </p>

</form>
</body>
</html>



