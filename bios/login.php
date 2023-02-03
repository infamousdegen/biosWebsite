<?php
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Title of the document </title>

    </head>
    <body>

    <?php
            if(isset($_SESSION['userId'])){
                echo "<p>You are Logged in </p>";
            }
            else{
                echo"<p>Session not set";
            }


?>

<form action = "includes/login.inc.php" method="POST">
    <br>
    <input type = "text" name = "uid" placeholder="Username">
    <br>
    <input type = "password" name = "pwd" placeholder="Password">
    <br>
    <button type = "submit" name = "submit" value = 'login-submit'> Sign In </button>
    <button type = "submit" name = "logout" value = "logout">Logout </button> 
</form>

            






    </body>
</html>