<?php
// Include the Pharmacist class file
require_once 'pharmacistclass.php';

// Instantiate the Pharmacist class
$Pharmacist = new Pharmacist();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if add button is clicked
    if (isset($_POST["add"])) {
        // Call the insertCustomer method with form data
        $Pharmacist->insertCustomer($_POST["name"], $_POST["address"], $_POST["contact"], $_POST["prod_name"], $_POST["memno"], $_POST["note"], $_POST["date"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <link rel="stylesheet" href="customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="customer.js"></script>
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
    <div id="ac">
        <!-- Your existing search form -->
        <div class="search">
            <form method="get" action="readcustomer.php" class="search-form">
                <input type="text" name="id" class="form-control" placeholder="Enter Customer ID" required>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        
        <!-- Button to toggle add customer form visibility -->
        <button id="addCustomerBtn">Add Customer</button>
        
        <!-- Form for adding customer (initially hidden) -->
        <div id="addCustomerForm" style="display: none;">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Input fields for adding customer -->
                <span>Full Name : </span><input type="text" name="name" placeholder="Full Name" required/><br>
                <span>Address : </span><input type="text" name="address" placeholder="Address"/><br>
                <span>Contact : </span><input type="text" name="contact" placeholder="Contact"/><br>
                <span>Product Name : </span><textarea name="prod_name"></textarea><br>
                <span>Total: </span><input type="text" name="memno" placeholder="Total"/><br>
                <span>Note : </span><textarea name="note"></textarea><br>
                <span>Expected Date: </span><input type="date" name="date" placeholder="Date"/><br>
                <button class="btn btn-success btn-block btn-large" type="submit" name="add"><i class="fas fa-save"></i> Save</button>
            </form>
        </div>
        
        <!-- Table to display customer details -->
        <?php
            // Call the method to display customers
            $Pharmacist->displayCustomers();
        ?>
    </div>
</body>
</html>
