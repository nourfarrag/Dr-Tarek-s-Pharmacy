<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Homepage.css">
    <style>
        /* Style for the notification section */
        .notification {
            background-color: #f2f2f2;
            color: #333;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management System</title>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->
</head>
<body>

<header>
    <div class="About">
        <h1>Dr. Tarek's Pharmacy</h1>
    </div>
</header>
<nav>
    <ul>
        <li><a href="CustomerHomepage.php"><i class="fas fa-home"></i>Home</a></li>
        <li><a href="prodhome.html"><i class="fas fa-capsules"></i>Products</a></li>
            <li><a href="payment.html"><i class="fas fa-chart-bar"></i>payment</a></li>
            <li><a href="currentlogin.html"></i>Login/SignUp</a></li>
        <li><a href="LoginForm.php"><i class="fas fa-logout"></i>Logout</a></li>
    </ul>
</nav>
<div class="container">
    <h1>Welcome to Customer Homepage</h1>
    <br>
</div>

<?php
if (isset($_GET['last_product'])) {
    $lastProductName = $_GET['last_product'];
    echo '<div class="notification">Last product added in the pharmacy is : ' . htmlspecialchars($lastProductName) . '</div>';
} else {
    echo '<div class="notification">No product added recently.</div>';
}
?>

<h4>
    <?php
    //echo ($_SESSION["fname"] . $_SESSION["minitial"] . $_SESSION["lname"]);
    ?>
</h4>
<main>
    <section class="dashboard">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    </section>
</main>
<footer>
    <p>&copy; 2024 Pharmacy Management System</p>
</footer>
<table>
    <tr>
        <th><a href="#">Offers</a></th>
        <th><a href="prescription.html">Prescription</a></th>
        <th><a href="#">Schedule Test</a></th>
    </tr>
    <tr>
        <td style="text-align: center;"><img src="Images/offers.png" alt="Offers"></td>
        <td style="text-align: center;"><img src="Images/prescribed-medicines.png" alt="Prescribed Medicines"></td>
        <td style="text-align: center;"><img src="Images/schedule-test.png" alt="Schedule Test"></td>
    </tr>
    <tr>
        <th><a href="#">Locations</a></th>
        <th><a href="#">Contact Methods</a></th>
    </tr>
    <tr>
        <td style="text-align: center;"><img src="Images/location.png" alt="Location"></td>
        <td style="text-align: center;"><img src="Images/contact-methods.png" alt="Contact Methods"></td>
    </tr>
</table>
</body>
</html>
