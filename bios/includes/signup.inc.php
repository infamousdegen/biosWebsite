
<?php   
require_once 'dbh.includes.php';

require_once 'functions.inc.php';


if(!isset($_POST["submit"]) || !($_POST["submit"] = 'signup-submit')){
    header("Location: ../index.php");
    echo "here1";
    exit();
}


$firstname = mysqli_real_escape_string($conn,$_POST["first"]); //note
$lastname = mysqli_real_escape_string($conn,$_POST["last"]);
$email = mysqli_real_escape_string($conn,$_POST["email"]);
$username = mysqli_real_escape_string($conn,$_POST["uid"]);
$password = mysqli_real_escape_string($conn,$_POST["pwd"]);

echo"here:";
if(emtpyInputSignup($firstname,$lastname,$email,$username,$password) !== false){
    header("Location: ../index.php?error=emptyinput");
    echo "here2";
    exit();  
}

if(invalidUid($username) !== false){
    header("Location: ../index.php?error=invalidusername");
    echo "here3";
    exit();  
}

if(invalidEmail($email) !== false){
    header("Location: ../index.php?error=invalidemail");
    echo "here4";
    exit();  
}

if(uidExists($conn,$username,$email) !== false){
    header("Location: ../index.php?error=usernametaken");
    echo "here5";
    exit();  
}

if(createUser($conn,$firstname,$lastname,$email,$username,$password) === true){
    header("Location: ../index.php?signup=success");
    echo "here6";
    exit();
}
else{
    header("Location: ../index.php?signup=failed");
    echo "here7";
}




