<?php

require_once 'includes/cookieManagement.php';
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.includes.php';

session_start();
        if(!isset($_SESSION)){
            header("Location: ./login.php");

        }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> UserDashboard </title>

        <?php


        //creating cookies
        if(isset($_POST["NickName"])){
            setcookie("NickName",$_POST["NickName"],time()+604800);
        }
        if(isset($_POST["Color"])){
            setcookie("Color",$_POST["Color"],time()+604800);
        }

        if(isset($_POST["Food"])){
            setcookie("Food",$_POST["Food"],time()+604800);
        }
        if(isset($_POST["Game"])){
            setcookie("Game",$_POST["Game"],time()+604800);
        }

        //Updating page according to cookies 

        if(isset($_COOKIE["NickName"])){
            echo "<h1> Welcome User " .$_COOKIE["NickName"];
        }

        if(isset($_COOKIE["Color"])){
            $hexcode = $_COOKIE["Color"];
            echo "<body style='background-color: $hexcode;'>";
        }


        if(isset($_COOKIE["Food"])){

            echo "<h1>Your Favourite Food is: ". $_COOKIE["Food"] ."</h1>";
        }


        if(isset($_COOKIE["Game"])){
            echo "<h1> You love to play: ". $_COOKIE["Game"] ."</h1>";
        }

        //reloading the page after setting the cookies
        if(isset($_POST["userPreference"])){
            header("Location: afterLogin.php");
        }

        if(isset($_POST["ResetChoice"])){
            foreach ($_COOKIE as $key => $value) {
                setcookie($key, '', time() - 3600);
            }
            header("Location: afterLogin.php");

        }

        if(isset($_POST["LogOut"])){
            deleteSessionandCookie();
            header("Location: login.php?status=loggedout");

        }

        if(isset($_POST["imageSubmit"])){
        $fileError = $_FILES['fileupload']['error'];
            if($fileError != 0){
                echo"Error uploading file";
            }
            else{
                    if(isImage() == true){
                            echo "Valid Image";
                    }
                    else echo "Invalid Image";
        }

        if(manageImage($conn,$_SESSION['userId'])){
            echo"<br>";
            echo "Upload successful";
        }

        var_dump($_POST);
        error_log("Debug info: I am outside deletepic ", 3, "logfile.txt");
        if(isset($_POST["deletepic"])){
            error_log("Debug info: I am inside deletepic ", 3, "logfile.txt");
            if(!deleteProfilePic($conn)){
                echo "<h1>profile pic deletion success</h1>";
            }
            else{
                echo "<h1>Error profile pic deletion</h1>";
            }
        }

    }





        ?>

        <?php

            $sql = "SELECT status from  profileimg WHERE userid = ?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "<h1>erro occured</h1>";
            }
            mysqli_stmt_bind_param($stmt,"i",$_SESSION['userId']);
            if(!mysqli_stmt_execute($stmt)){
                echo "<h1> Erro occured while checking for profile image </h1>";
            }
            $result = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)){
                $status = $row['status'];

            }
            echo "<div>";

            if($status == 0){
                echo "<img src='uploads/default.jpg'>";
                
            }
            else{
                $filePath = "uploads/"."profile".$_SESSION['userId'].".*";
                $image_files = glob($filePath);

                if (count($image_files) > 0) {
                    echo "<img src = '".$image_files[0]."'width='200' height='200'>";
                  }
                else{
                    "Echo no file found";
                }



            }

            echo "</div>";

        ?>





        <form action="afterLogin.php" method="POST" >
        <input type = "text" name = "NickName" placeholder="What should we call you ?">
        <br>
        <input type = "text" name = "Color" placeholder="Enter back ground color in hex">
        <br>
        <input type = "text" name = "Food" placeholder="What's your favorite food">
        <br>
        <input type = "text" name = "Game" placeholder="Whats your favorite video game">
        <br>

        <br>
        <button type = "submit" , name = "userPreference" , value ="Updating"> Submit the choices </button>
        <br>
        <button type = "submit", name = "ResetChoice" , value ="Resetting Choice">Reset your preferences</button>
        <br>
        <button type = "submit" , name = "LogOut", value = "LoggingOut">Logout</button>
        </form>

        <!-- uploading image files -->
        <h1>Profile Pic Section </h1>
        <h4>Upload your profile Pic</h4>

        <form action="afterLogin.php" , method = "POST" enctype='multipart/form-data'>
        <input type = "file" name = "fileupload">
        <br>
        <button type = "submit" name = "imageSubmit" value="imagesubmit">Submit</button>
        <br>
        </form>

        <form action="afterLogin.php" , method = "POST">
        <br>
        <button type = "submit" name = "deletepic" value="deletepic">delete profile pic</button>
        <br>
        </form>


        <a href = "./ProfileUpdate.php">Update Profile</a>


    </head>
    <body>







    </body>
</html>