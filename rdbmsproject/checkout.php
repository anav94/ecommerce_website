<?php
// Start or resume a session
session_start();
// echo "Before any checks";
// Check if username is set in session
if (isset($_SESSION["username"])) {
    // Retrieve username from session
    $username_ = $_SESSION["username"];
    

    // Check if cartItems is set in POST data
    if (isset($_POST['cartItems'])) {
        // Decode cartItems from JSON format
        $cartItems = json_decode($_POST['cartItems'], true);

        // Include your connection file
        include 'connect.php';

        // Prepare statement for inserting data
        $stmt = $connection->prepare("INSERT INTO orders (username, product_name, product_price) VALUES (?, ?, ?)");

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssd", $username_, $productName, $productPrice);

            // Iterate through each cart item
            foreach ($cartItems as $item) {
                $productName = $connection->real_escape_string($item['name']);
                $productPrice = $item['price'];
                $stmt->execute();
            }

            // Close statement
            $stmt->close();

            // Unset cart from session
            unset($_SESSION['cart']);

            // Send response
            echo "Order placed successfully!";
        } else {
            // Error preparing statement
            echo "Error preparing statement: " . $connection->error;
        }
    } else {
        // cartItems not found in POST data
        echo "Cart items not found.";
    }
} else {
    // Username not found in session
    echo "Username not found in session.";
}
?>
