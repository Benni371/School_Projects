<?php
session_start();
if(!isset($_SESSION["logged_in"]))
{
  header("location: ./views/login.php?error=invalidLogin");
  exit();
}
include_once './actions/functions.php';
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

?>
<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8" HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="./css/styles.css">
      <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>

      <title>The Daily Grind</title>
    </head>
    <body>
      <nav class="logout">
        <button><a href="https://www.youtube.com/watch?v=xvFZjo5PgG0">Laugh</a></button>
        |
        <button ><a href="">Filler</a></button>|
        <button ><a href="">Filler</a></button>|
        <button ><a href="">Filler</a></button>|
        <button ><a href="actions/logout_action.php">Log Out</a></button>


      </nav>
      <h1>Welcome to The Daily Grind</h1>

      <input type='checkbox' name='cb1' class='toggle-switch'/><label for='cb1'>Sort By Date</label>
      <input type='checkbox' name='cb2' class='toggle-switch'/><label for='cb2'>Filter Completed</label>
      <?php
          if(isset($_GET["status"])){
            if($_GET["status"] == "taskAdded"){
                echo "<p class=\"error\"><label class=\"material-icon\">check_circle</label>&nbsp; Task Created Successfully</p>";
            }
        }
      
      ?>
        <div class="tasklist">
        <ul>
          <?php 
            $name = $_SESSION["uname"];
            $id = $_SESSION["id"];
            echo readTasks($conn, $name, $id);
            
          ?>
        </ul>
      </div>
      <div>
        <form action="./actions/create_action.php" method="POST">
          <input type="text" name="txt" id="details"></br>
          <input type="date" name="date" id="date"></br>
          <button class="longBtn">Create Task</button></br>
        </form>
      </div>
    </body>

    </html>