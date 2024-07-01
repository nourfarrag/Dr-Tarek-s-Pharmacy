<?php

// Function to connect to the database
function connectToDatabase($servername, $username, $password, $database) {
    // Enable error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to update customer data
function updateCustomerData($conn, $customerId, $new_name, $new_address, $new_contact) {
    $stmt = $conn->prepare("UPDATE customers SET FullName=?, Address=?, Contact=? WHERE CustomerID=?");
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("sssi", $new_name, $new_address, $new_contact, $customerId);
    if ($stmt->execute()) {
        echo "success"; // Return success message
    } else {
        echo "Error updating customer data: " . $stmt->error; // Return error message
    }

    $stmt->close();
}

// Check if data is received via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve JSON data from POST request body
    $json_data = file_get_contents("php://input");
    
    // Decode JSON data into associative array
    $data = json_decode($json_data, true);

    // Extract individual fields from the data
    $customerId = $data['CustomerId'];
    $new_name = $data['new_name'];
    $new_address = $data['new_address'];
    $new_contact = $data['new_contact'];

    // Validate input data (optional but recommended)
    if (empty($customerId) || empty($new_name) || empty($new_address) || empty($new_contact)) {
        echo "Error: Please fill in all fields.";
        exit;
    }

    // Connect to the database
    $conn = connectToDatabase("localhost", "root", "", "dr. tarek's pharmacy");

    // Update customer data
    updateCustomerData($conn, $customerId, $new_name, $new_address, $new_contact);

    // Close database connection
    $conn->close();
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>
