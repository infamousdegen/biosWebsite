<?php
            require_once 'dbh.includes.php';
            require_once 'functions.inc.php';
            require_once 'cookieManagement.php';
    
    if(!isset($_POST['submit']) && (!$_POST['submit'] == 'admin-submit')){
        header("Location: ../login.php");
            exit();
        
        }

    session_start();

    $UserName = mysqli_real_escape_string($conn,$_POST["uid"]);
    $PassWord = mysqli_real_escape_string($conn,$_POST["pwd"]);

    if(checkingLogin($conn,$UserName,$PassWord) === false){
        header("Location: ../adminLogin.php?status=loginfailed");
        exit();
    }

    else{
        $row = getLoginDetails($conn,$UserName );
        var_dump($row);

        if($row['user_id'] == 84){
        $_SESSION['adminId'] = $row['user_id'];
        $_SESSION['admin'] =  $UserName;

        header("Location: ../afterAdminLogin.php");
        exit();
        }
        else{
            header("Location: ../adminLogin.php?error=LoginError");
        }

        
    }


        


?>