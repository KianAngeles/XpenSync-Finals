
<?php
$host = "localhost";
$user = "root";  
$pass = "";     
$dbname = "xpensync";  

$db = new mysqli($host, $user, $pass, $dbname);

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}


?>
