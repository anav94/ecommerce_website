<?php

include 'connect.php'; // Include your database connection script



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empID = $_POST["empID"];
    $empPassword = $_POST["empPassword"];
    
    if (empty($empID) || empty($empPassword)) {
        // Input validation: Ensure both employee ID and password are provided
        echo '<script>alert("Please Enter Employee ID and Password!");</script>';
        echo '<script>window.location.href = "employee_register.html";</script>';
        exit(); // Stop further execution
    } else {
        // Check if employee ID already exists
        $check_query = "SELECT * FROM employees WHERE emp_id = ?";
        $check_stmt = $connection->prepare($check_query);
        $check_stmt->bind_param("s", $empID);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Employee ID already exists
            echo '<script>alert("Employee ID already exists!");</script>';
            echo '<script>window.location.href = "employee_register.html";</script>';
            exit(); // Stop further execution
        }

        // Hash the password
        $hashedPassword = password_hash($empPassword, PASSWORD_DEFAULT);

        // Query the database to insert employee details
        $query = "INSERT INTO employees (emp_id, password) VALUES (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $empID, $hashedPassword);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows == 1) {
            // Registration successful, start session and redirect to homepage
            session_start();
            $_SESSION['empID'] = $empID;
            echo '<script>alert("Employee Registration Successful");</script>';
            echo '<script>window.location.href = "temp.html";</script>';
            exit(); // Stop further execution
        } else {
            // Insertion failed
            echo '<script>alert("Employee Registration Failed");</script>';
            echo '<script>window.location.href = "employee_register.html";</script>';
            exit(); // Stop further execution
        }
    }
}

// Close database connection (This line will never be reached because of the earlier exit() calls after redirection)
$connection->close();
?>
