<?php
session_start();

        require_once 'dbh.includes.php';
        require_once 'functions.inc.php';
        require_once 'cookieManagement.php';


        if(!empty($_POST['logout'])) {
            deleteSessionandCookie();
            header("Location: ../login.php?status=loggedout");
            exit();

        }

        if(!isset($_POST['submit']) || (!$_POST['submit'] == 'login-submit')){
            header("Location: ../login.php");
            exit();

        }

        $UserName = mysqli_real_escape_string($conn,$_POST["uid"]);
        $PassWord = mysqli_real_escape_string($conn,$_POST["pwd"]);

        if(emtpyInputLogin($UserName,$PassWord) !== false){

            header("Location: ../login.php?status=emptyinput");
            exit();
        }

        if(checkingLogin($conn,$UserName,$PassWord) === false){
            header("Location: ../login.php?status=loginfailed");
            exit();
        }
        else{
            $row = getLoginDetails($conn,$UserName );
            $_SESSION['userId'] = $row['user_id'];
            $_SESSION['username'] =  $UserName;
            

            

            header("Location: ../afterLogin.php");
            exit();
        }



