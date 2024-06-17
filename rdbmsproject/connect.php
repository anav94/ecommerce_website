<?php

// Assuming you have a database connection established
$hostname = "127.0.0.1"; // Hostname
$username = "root"; // MySQL username
$password = "Dino_2017"; // MySQL password
$database = "rdbmsproject"; // MySQL database name

// Create connection
$connection = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>