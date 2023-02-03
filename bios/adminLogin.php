<?php

    if(isset($_SESSION['userId'])){
        echo "Logout out of other users";

        header("Location: login.php?error=logout");
    }

    session_start();
?>

<form action = "includes/adminLoginManagement.php" method="POST">
    <br>
    <input type = "text" name = "uid" placeholder="Username">
    <br>
    <input type = "password" name = "pwd" placeholder="Password">
    <br>
    <button type = "submit" name = "submit" value = 'admin-submit'> Sign In </button>
    <button type = "submit" name = "logout" value = "logout">Logout </button> 
</form>

