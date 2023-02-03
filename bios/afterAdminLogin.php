<?php

    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.includes.php';
    require_once 'includes/updateProfileFunctions.php';

session_start();
        if(!isset($_SESSION['adminId']) && !isset($_SESSION['admin'])){
            header("Location: ./login.php");

        }

        if(isset($_POST['submit'])){

        if(isset($_POST['userId'])){
            if(userIdExists($conn,$_POST['userId'])){
                if(!empty($_POST['FirstName'])){
                    updateFirstName($conn,$_POST['userId'],$_POST['FirstName']);

                }

                if(!empty($_POST['LastName'])){
                    updateLastName($conn,$_POST['userId'],$_POST['LastName']);
                }

                if(!empty($_POST['Email'])){
                    updateEmail($conn,$_POST['userId'],$_POST['Email']);
                }

                if(!empty($_POST['Username'])){
                    updateUserName($conn,$_POST['userId'],$_POST['Username']);
                }

                if(!empty($_POST['password'])){
                    var_dump($_POST);
                    updatePassword($conn,$_POST['userId'],$_POST['password']);
                }



            }
            else{
                echo "UserId Does Not Exist";
            }
        }

        else{
            echo "No User Id mentioned";
        }
    }

    if(isset($_POST['DeleteUser'])){
        if(userIdExists($conn,$_POST['userId'])){
            deleteUser($conn,$_POST['userId']);

        }
        else"Echo No user Id found";
    }



?>

        <form action = "afterAdminLogin.php" method = "POST">
            <input type = "text" name = "userId" placeholder="Enter User Id"/>
            <br>
            <input type = "text" name = "FirstName" placeholder="Update First name"/>
            <br>
            <input type = "text" name = "LastName" placeholder="Update Last name"/>
            <br>
            <input type = "text" email = "Email" placeholder="Update Email"/>
            <br>
            <input type = "text" name = "Username" placeholder="Update User name"/>
            <br>
            <input type = "password" name = "password" placeholder="Update Password"/>
            <br>
            <button type ="submit" name = 'submit' value = 'submit'>Submit </button>
            <br>
            <button type = 'submit' name = 'DeleteUser' value = 'deleteUser'>Delete User</button>
            <br>
  

        </form>

