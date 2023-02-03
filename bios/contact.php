<?php

    session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Title of the document </title>

    </head>
    <body>

<ul>
    <li> <a href = "index.php">HOME </a> </li>
    <li> <a href="contact.php">CONTACT </a></li>
</ul>

<?php

     echo $_SESSION['username'];


?>




    </body>
</html>