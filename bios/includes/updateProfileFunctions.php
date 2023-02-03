<?php
        require_once "functions.inc.php";

    function updateFirstName($conn,$userId,$firstname){
        $sql = "UPDATE users SET user_first = ? where user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=UpdatingValues");
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"si",$firstname,$userId);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }
    }

    function updateLastName($conn,$userId,$LastName){
        $sql = "UPDATE users SET user_last = ? where user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=UpdatingValues");
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"si",$LastName,$userId);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }
    }

    function updateEmail($conn,$userId,$Email){
        if(invalidEmail($Email)){
            header("Location: ../Login.php?error=InvalidEmailUpdating");
            exit();
        }
        $sql = "UPDATE users SET user_email = ? where user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=UpdatingValues");
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"si",$Email,$userId);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }
    }

    function updateUserName($conn,$userId,$UserName){
        if(invalidUid($UserName)){
            var_dump($_POST);
            header("Location: ../login.php?error=InvalidUsername");
            exit();
        }
        $sql = "UPDATE users SET user_uid = ? where user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=UpdatingValues");
            exit();  
        }


        mysqli_stmt_bind_param($stmt,"si",$UserName,$userId);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }
    }

    function updatePassword($conn,$userId,$Password){

        $hashedPassword = password_hash($Password,PASSWORD_DEFAULT);
        $sql = "UPDATE users SET user_pwd = ? where user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=UpdatingValues");
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"si",$hashedPassword,$userId);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }
    }

    function deleteUser($conn,$userId){

        $sql = "DELETE FROM users WHERE user_id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../Login.php?error=deleteUser");
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"i",$userId);

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        else{
            return false;
        }


    }


?>