<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $orgprice=$_POST['orgprice'];
    $productcode=$_POST['productcode'];

    $profit=$price-$orgprice;

        
    // Get the current date
    $current_date = date("Y-m-d");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dr. tarek's pharmacy";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO `orderpro` (`product_name`, `price`,`profit`,`orgprice`,`productcode`) VALUES (?,?,?,?,?)");
    if (!$stmt) {
        die("Error in prepare: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sddds", $product_name, $price, $profit, $orgprice, $productcode);


    // Execute SQL statement
    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $stmt->error;  
    }

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
