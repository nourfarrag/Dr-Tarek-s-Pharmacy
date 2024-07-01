<?php
    session_start();
    require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pharmacy Management System</title>
        <link rel="stylesheet" href="/Our-software-engineering-project-main/Dr. Tarek's Pharmacy/CSS/Homepage.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
        <header>
            <div class="About">
                <h1>Pharmacy Management System</h1>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="#"><i class="fas fa-file-medical-alt"></i> Orders</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Customers</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="Suppliers.php"><i class="fas fa-chart-bar"></i> Suppliers</a></li>
                <li><a href="LoginForm.php"><i class="fas fa-logout"></i>Logout</a></li>
            </ul>
        </nav>
        <main>
            <section class="dashboard">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            </section>
        </main>
        <footer>
            <p>&copy; 2024 Pharmacy Management System</p>
        </footer>
        <table>
            <tr> <th><a href="#">Account</a></th><th><a href="#">Prescription</a></th><th><a href="#">Stock</a></th> </tr>
            <tr> <td style="text-align: center;"><img src="/Dr. Tarek's Pharmacy/Images/pharmacist-removebg-preview.png" alt="Account"></td> <td style="text-align: center;"><img src="/Dr. Tarek's Pharmacy/Images/prescription-removebg-preview.png" alt="Prescription"></td> <td style="text-align: center;"><img src="/Dr. Tarek's Pharmacy/Images/cashier-removebg-preview.png" alt="Stock"></td> </tr>
            <tr> <th><a href="productlist.php">Product List</a></th> <th><a href="#">Make Payments</a></th> </tr>
            <tr> <td style="text-align: center;"><a href="productlist.php"><img src="/Dr. Tarek's Pharmacy/Images/productlist-removebg-preview.png" alt="Product List"></a></td> <td style="text-align: center;"><img src="/Dr. Tarek's Pharmacy/Images/pay-removebg-preview.png" alt="Make Payments"></td> </tr>
        </table>
    </body>
</html>
