<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <link rel="shortcut icon" type="image/jpg" href="../favicon.ico"/>

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 -->
    <link rel="stylesheet" href="../css/styles.css">
    
    <title>Login</title>
</head>

<body class="loginBody">
    <h1 class="header">Login</h1>
    <?php 
    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Please fill in all fields</p>";
        }
        else if($_GET["error"] == "wrongLogin1" || $_GET["error"] == "wrongLogin2"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Invalid username or password</p>";
        }
        else if($_GET["error"] == "invalidLogin"){
            echo "<p class=\"error\"><label class=\"material-icon\">warning_amber</label>&nbsp; Prohibited Access: Please login</p>";
        }
    }
?>

    <form action="../actions/login_action.php" method="POST" class="formTable">
    <p>    
        <label class="login" for="uname">Username:&nbsp;</label><input class="login" type="text" name="uname">
    </p>
    <br>
    <p>
        <label class="login" for="pword">Password:&nbsp;</label><input class="login" type="password" name="pword" >
    </p>
    <br>
    <p>
        <label for="">&nbsp;</label>    
        <button class="btn longBtn" name="submit">Login</button>
    </p>
    <br>
    <p>
        <label for="">&nbsp;</label>Don't have an account? <a href="./register.php">Register Here</a> </p>


    </form>
</body>
</html>