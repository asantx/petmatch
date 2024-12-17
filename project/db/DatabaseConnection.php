<?php
$servername = 'localhost';
$username = 'asantewaa.asante';
$password = '28132026';
$db = 'webtech_fall2024_asantewaa_asante';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    echo 'Error';
} 

?>