<?php
        require_once 'dbh.includes.php';
        require_once "functions.inc.php";

        session_start();
                if(!isset($_SESSION) and !isset($_POST["SubmitFromProfileUpdate"])){
                    header("Location: ./login.php");
        
                }
                //to update fist name 
                if(!empty($_POST['FirstName'])){
                    $firstname = mysqli_real_escape_string($conn,$_POST["FirstName"]);
                    $sql = "UPDATE users SET user_first = ? where user_id = ?;";

                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../ProfileUpdate.php?error=UpdatingValues");
                        exit();  
                    }

                    mysqli_stmt_bind_param($stmt,"si",$firstname,$_SESSION["userId"]);
                    if(mysqli_stmt_execute($stmt)){
                        header("Location: ../ProfileUpdate.php?success");
                        mysqli_stmt_close($stmt);
                    }
                    else{
                        header("Location: ../ProfileUpdate.php?error=FirstName");
                    }
                    

                }

                //to update last name

                if(!empty($_POST['LastName'])){
                    $LastName = mysqli_real_escape_string($conn,$_POST["LastName"]);
                    $sql = "UPDATE users SET user_last = ? where user_id = ?;";

                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../ProfileUpdate.php?error=UpdatingValues");
                        exit();  
                    }

                    mysqli_stmt_bind_param($stmt,"si",$LastName,$_SESSION["userId"]);
                    if(mysqli_stmt_execute($stmt)){
                        header("Location: ../ProfileUpdate.php?success");
                        mysqli_stmt_close($stmt);
                    }
                    else{
                        header("Location: ../ProfileUpdate.php?error=LastName");
                    }


                }


                //to update the email

                if(!empty($_POST['Email'])){
                    $Email = mysqli_real_escape_string($conn,$_POST["Email"]);
                    if(invalidEmail($Email)){
                        header("Location: ../ProfileUpdate.php?error=InvalidEmail");
                        exit();
                    }
                    $sql = "UPDATE users SET user_email = ? where user_id = ?;";

                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../ProfileUpdate.php?error=UpdatingValues");
                        exit();  
                    }

                    mysqli_stmt_bind_param($stmt,"si",$Email,$_SESSION["userId"]);
                    if(mysqli_stmt_execute($stmt)){
                        header("Location: ../ProfileUpdate.php?success");
                        mysqli_stmt_close($stmt);
                    }
                    else{
                        header("Location: ../ProfileUpdate.php?error=email");
                    }


                    //setting password

                    if(!empty($_POST['Password'])){
                        $password = mysqli_real_escape_string($conn,$_POST["Password"]);
                        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET user_pwd = ? where user_id = ?;";
    
                        $stmt = mysqli_stmt_init($conn);
    
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../ProfileUpdate.php?error=PassWordError");
                            exit();  
                        }
    
                        mysqli_stmt_bind_param($stmt,"si",$hashedPassword,$_SESSION["userId"]);
                        if(mysqli_stmt_execute($stmt)){
                            header("Location: ../ProfileUpdate.php?success");
                            mysqli_stmt_close($stmt);
                        }
                        else{
                            header("Location: ../ProfileUpdate.php?error=PassWord");
                        }


    
    
                    }
                
    

                }






?>