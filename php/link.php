<?php
$host="localhost";
$login="root";
$password="";
$database="demodemoex";
$link=mysqli_connect($host,$login,$password,$database);

if ($link -> connect_errno) {
    die( "Failed to connect to MySQL: " . $link -> connect_error);
}


?>