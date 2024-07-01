<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dr. tarek's pharmacy";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

class Product {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function updateProduct($productId, $name, $price, $quantity, $expiry) {
        $stmt = $this->conn->prepare("UPDATE products SET Product_Name=?, Product_Quantity=?, Product_Price=?, Product_ExpiryDate=? WHERE Product_ID=?");
        if (!$stmt) {
            die("Error in prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ssssi", $name, $price, $quantity, $expiry, $productId);

        if ($stmt->execute()) {
            echo '<script>
                    alert("Record updated successfully.");
                    window.location.replace("productlist.php");
                  </script>';
        } else {
            echo '<script>
                    alert("Record update unsuccessful.");
                    window.location.replace("productlist.php");
                  </script>';
        }

        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();
    $product = new Product($db);

    $productId = isset($_POST['productId']) ? $_POST['productId'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : '';

    $product->updateProduct($productId, $name, $price, $quantity, $expiry);
} else {
    echo "Invalid request method";
}
?>
