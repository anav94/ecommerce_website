<?php

include 'connect.php'; // Include your database connection script



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($password) || empty($email)) {
        // Input validation: Ensure both email and password are provided
        echo '<script>alert("Please Enter the Details!");</script>';
        echo '<script>window.location.href = "login.html";</script>';
        exit(); // Stop further execution
    } else {
        // Query the database to fetch user details
        $query = "INSERT INTO customers(email, password) VALUES(?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        session_start();
        $_SESSION['username'] = $username;
       
        

  
        echo '<script>window.location.href = "homepage.html";</script>';

        if ($result->num_rows == 1) {
            // If user exists, fetch the hashed password
            $row = $result->fetch_assoc();
            // $hashed_password = $row['hashed_password'];
            
            // Verify the password
            // if (password_verify($password, $hashed_password)) {
                // Password is correct, start session and redirect to homepage
                 //session_start();
                 //$_SESSION['email'] = $row['email'];
                
                exit(); // Stop further execution
            // } else {
            //     // Password is incorrect
            //     echo '<script>alert("Invalid Credentials");</script>';
            //     echo '<script>window.location.href = "login.html";</script>';
            //     exit(); // Stop further execution
            // }
        } else {
            // No user found with the given email
            echo '<script>alert("Invalid Credentials");</script>';
            echo '<script>window.location.href = "login.html";</script>';
            exit(); // Stop further execution
        }
    }
}

// Close database connection (This line will never be reached because of the earlier exit() calls after redirection)
$connection->close();
?>
