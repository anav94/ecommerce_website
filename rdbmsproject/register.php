<?php

include 'connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($password) || empty($email)) {
        echo '<script>alert("Please Enter the Details!");</script>';
        echo '<script>window.location.href = "login.html";</script>';
        exit(); // Stop further execution
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Store $hashed_password in the database
    // echo '<script>console.log(' . $hashed_password . ')</script>';
    $query = "INSERT INTO users(email, password) VALUES(?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss",$email,  $hashed_password);
    $stmt->execute();
    
    if ($stmt->affected_rows == 1) {
        // Registration successful
        echo '<script>alert("User Registered");</script>';
        echo '<script>window.location.href = "login.html";</script>';
        exit(); // Stop further execution
    } else {
        // Registration failed
        echo '<script>alert("Registration failed due to some errors. Please try again later.");</script>';
        echo '<script>window.location.href = "login.html";</script>';
        exit(); // Stop further execution
    }
}

?>