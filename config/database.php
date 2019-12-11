<?php
define('DB_SERVER','localhost');
define('DB_USER','spydernet');
define('DB_PASS' ,'Rm150620071010');
define('DB_NAME', 'spydernet');
$mysqli = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

$sql_details = array(
    'user' => "spydernet",
    'pass' => "Rm150620071010",
    'db'   => "spydernet",
    'host' => 'localhost'
);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

?>
