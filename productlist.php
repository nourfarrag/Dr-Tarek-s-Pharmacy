<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Product List</title>
    <link rel="stylesheet" href="/Dr. Tarek's Pharmacy/CSS/productlist.css">
</head>
<body>
    <h2>Pharmacy Product List</h2>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTable">
            <?php
            // Database configuration
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "dr. tarek's pharmacy";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the database
            $sql = "SELECT * FROM products ORDER BY Product_ID ASC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Product_ID"] . "</td>";
                    echo "<td>" . $row["Product_Name"] . "</td>";
                    echo "<td>" . $row["Product_Quantity"] . "</td>";
                    echo "<td>" . $row["Product_Price"] . "</td>";
                    echo "<td>" . $row["Product_ExpiryDate"] . "</td>";
                    echo '<td>
                            <button class="edit" onclick="editProduct(this)">Edit</button>
                            <button class="delete" onclick="deleteProduct(this)">Delete</button>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>

    <form action="productlistdb.php" method="POST">
        <div id="addProductForm" style="display: none;">
            <input type="text" id="productName" name="productName" placeholder="Product Name">
            <input type="number" id="productQuantity" name="productQuantity" placeholder="Quantity">
            <input type="number" id="productPrice" name="productPrice" placeholder="Price">
            <input type="date" id="Expirydate" name="Expirydate" placeholder="Expiry Date">
            <button type="submit">Submit Product</button>
        </div>
    </form>

    <div class="center">
        <button type="button" onclick="showAddProductForm()">Add Product</button>
    </div>

    <script src="productlist.js"></script>
</body>
</html>
