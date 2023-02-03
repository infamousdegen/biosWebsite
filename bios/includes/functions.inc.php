<?php

use function PHPSTORM_META\map;

    require_once 'dbh.includes.php';

    function emtpyInputSignup($firstname,$lastname,$email,$username,$password){
        if(empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password)){
            return true;
        }

        return false;
    }

    function invalidUid($username){
        //will check if there is atleast 1 letters and rest alpha num characters
        if(!preg_match('/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/',$username)){
            return true;
        }
        return false;

    }


    function invalidEmail($email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    function uidExists($conn,$username,$email){
        $sql = "select * from users where user_uid = ? OR user_email = ?;";

        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=stmtfailed");
            exit();  
        }
        mysqli_stmt_bind_param($stmt,"ss",$username,$email);
        mysqli_stmt_execute($stmt);


        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        mysqli_stmt_close($stmt);
        return false;



    }

    function userIdExists($conn,$userId){
        $sql = "select * from users where user_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../index.php?error=stmtfailed");
            exit();  
        }
        mysqli_stmt_bind_param($stmt,"s",$userId);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        mysqli_stmt_close($stmt);
        return false;

    }

    function createUser($conn,$firstname,$lastname,$email,$username,$password){
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(user_first,user_last,user_email,user_uid,user_pwd) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            return false;
            exit();  
        }

        mysqli_stmt_bind_param($stmt,"sssss",$firstname,$lastname,$email,$username,$hashedPassword);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        //get currently created users user id

        $sql2 = "SELECT user_id from users where user_uid = ?;";
        $stmt2 = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt2,$sql2)){
            return false;
            exit();  
        }

        mysqli_stmt_bind_param($stmt2,"s",$username);
        mysqli_stmt_execute($stmt2);
        $resultData = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($resultData);
        $userid = $row['user_id'];
        mysqli_stmt_close($stmt2);
        



        $sqlimg = "INSERT into profileimg(userid,status) values (?,?);";
        $stmt3 = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt3,$sqlimg )){
            return false;
            exit();  
        }

        $status = 0;

        mysqli_stmt_bind_param($stmt3,"ii",$userid,$status);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);

        return true;
        exit();

    }

    //login section 


    function emtpyInputLogin($UserName,$PassWord){
        if(empty($UserName) || empty($PassWord)){
            return true;
        }
        return false;
    }


    function checkingLogin($conn,$username,$PassWord){
        $sql = "SELECT * from users WHERE user_uid = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            return false;
            exit();
        }

        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)){
            $pwdCheck = password_verify($PassWord,$row['user_pwd']);

            if($pwdCheck){
                return true;
            }
            else {
                return false;
            }

        }
        else{
            return false;
        }

        return false;

        

    }

    function getLoginDetails($conn,$username){
        echo"here";
        $sql = "SELECT user_id from users WHERE user_uid = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../login.php?error=ErrorOccured");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return($row);



    }


    //image section . Checking whether the uploaded image was value 

    function isImage() {
        //checking whether the .extension was also correct 
        $fileName = $_FILES['fileupload']['name'];

        $fileExt = pathinfo($fileName,PATHINFO_EXTENSION);

        $allowed = array('jpg','jpeg','png');

        if (!in_array($fileExt,$allowed)){
                return false;
        }



        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $_FILES['fileupload']['tmp_name']);
        if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg'  || $mimetype == 'image/png') {
                    return true;
            } 

        return false;

    }


    function manageImage($conn,$id) {
        $fileTmpName = $_FILES['fileupload']['tmp_name'];
        $fileName = $_FILES['fileupload']['name'];

        $fileExt = pathinfo($fileName,PATHINFO_EXTENSION);

        $newFileName =  "profile".$id.".".$fileExt;
        $fileDestination = './uploads/'.$newFileName;

        //deleting previous images if it exists
        $filePath = "./uploads/"."profile".$_SESSION['userId'].".*";
        $image_files = glob($filePath);
        if(!empty($image_files)){
            if(file_exists($image_files[0])){
                unlink($image_files[0]);
            }
        }
        else{
            echo"no file found";
        }




        if(!move_uploaded_file($fileTmpName,$fileDestination)){
            return false;
        }


        //updating profile image database
        $sql = "UPDATE profileimg SET status = ? WHERE userid = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            return false;
        }
        $status = 1;
        mysqli_stmt_bind_param($stmt,"ii",$status,$id);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            return true;
        }
        

    }


    function deleteProfilePic($conn){
        echo "here";
        error_log("Debug info: This is a log message", 3, "../logfile.txt");
        $filePath = "uploads/"."profile".$_SESSION['userId'].".*";
        $image_files = glob($filePath);
        if(!empty($image_files)){
            if(file_exists($image_files[0])){
                unlink($image_files[0]);
            }
        }

        //updating the sql table

        $sql = "UPDATE profileimg SET status = ? WHERE userid = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            return false;
        }
        $status = 0;
        mysqli_stmt_bind_param($stmt,"ii",$status,$id);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
        }
    }



?>



