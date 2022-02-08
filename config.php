<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'eu-cdbr-west-02.cleardb.net');
define('DB_USERNAME', 'b3ff51d972250f');
define('DB_PASSWORD', 'bf0598af');
define('DB_NAME', 'heroku_2f94a8f46a09c1a');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
