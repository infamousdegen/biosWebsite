<?php
session_start();
        if(!isset($_SESSION)){
            header("Location: ./login.php");

        }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Title of the document </title>

    </head>
    <body>

    
    <form action="includes/updateprofile.inc.php" method = "POST">
        <p>Update First Name </p>
    <input type = "text" name = "FirstName" placeholder="First_Name" />
        <p>Update Last Name</p>
    <input type = "text" name = "LastName" placeholder="LastName" />

    <p>Update Email</p>
    <input type = "text" name = "Email" placeholder="Email" />

    <p>Update Password</p>
    <input type = "password" name = "Password" placeholder="password"/>
    <button type = "submit" name = "SubmitFromProfileUpdate" >Update</button>
    </form>





    </body>
</html>