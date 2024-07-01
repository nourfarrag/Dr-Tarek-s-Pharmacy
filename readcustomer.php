<?php
// Include configuration file to establish database connection
require_once "config.php";

// Function to sanitize input
function sanitize($input) {
    return trim($input);
}

// Function to retrieve customer details from the database
function retrieveCustomerDetails($link, $customerId) {
    $customerId = sanitize($customerId);
    $stmt = mysqli_prepare($link, "SELECT * FROM Customers WHERE CustomerId = ?");
    mysqli_stmt_bind_param($stmt, "i", $customerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        return null;
    }
}

// Initialize variables
$customerId = '';
$fullName = ''; // Initialize $fullName variable

// Check if form is submitted with Customer ID
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve and sanitize customer ID
    $customerId = isset($_GET["id"]) ? $_GET["id"] : '';

    if (!empty($customerId)) {
        // Retrieve customer details
        $customer = retrieveCustomerDetails($link, $customerId);
        // Assign customer details to variables
        if ($customer) {
            $fullName = $customer['FullName']; // Assign FullName to $fullName variable
            $address = $customer['Address'];
            $contact = $customer['Contact'];
            $productName = $customer['ProductName'];
            $total = $customer['Total'];
            $note = $customer['Note'];
            $expectedDate = $customer['ExpectedDate'];
        }
    }
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <link rel="stylesheet" href="customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS for the back button */
        #backButton {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745; /* Green color */
            color: #fff; /* White text */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        #backButton:hover {
            background-color: #218838; /* Darker green color on hover */
        }
    </style>
</head>
<body>
    <header>
        <div class="About">
            <h1>DR.Tarek's Pharmacy</h1>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-capsules"></i> Products</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Cart</a></li>
            <li><a href="#"><i class="fas fa-sign-in-alt"></i> Login/SignUp</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <?php if(!empty($fullName)): ?>
            <table class="table table-bordered" id="resultTable">
                <tr>
                    <td><strong>CustomerId:</strong></td>
                    <td><?php echo $customerId; ?></td>
                </tr>
                <tr>
                    <td><strong>Full Name:</strong></td>
                    <td><?php echo $fullName; ?></td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td><?php echo $address; ?></td>
                </tr>
                <tr>
                    <td><strong>Contact:</strong></td>
                    <td><?php echo $contact; ?></td>
                </tr>
                <tr>
                    <td><strong>Product Name:</strong></td>
                    <td><?php echo $productName; ?></td>
                </tr>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><?php echo $total; ?></td>
                </tr>
                <tr>
                    <td><strong>Note:</strong></td>
                    <td><?php echo $note; ?></td>
                </tr>
                <tr>
                    <td><strong>Expected Date:</strong></td>
                    <td><?php echo $expectedDate; ?></td>
                </tr>
            </table>
            <button id="backButton" onclick="goBack()"><i class="
            fas fa-arrow-left"></i> Back to Customers</button>
<?php else: ?>
<div class="detail">
No data found.
</div>
<?php endif; ?>
</div>
<script>
function goBack() {
window.history.back();
}
</script>
</body>
</html>