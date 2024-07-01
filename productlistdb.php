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

    public function addProduct($pname, $price, $quantity, $expiry) {
        $stmt = $this->conn->prepare("INSERT INTO products(`Product_Name`, `Product_Quantity`, `Product_Price`, `Product_ExpiryDate`) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Error in prepare: " . $this->conn->error);
        }

        $stmt->bind_param("sdss", $pname, $quantity, $price, $expiry);

        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();
    $product = new Product($db);

    $pname = $_POST['productName'];
    $price = $_POST['productPrice'];
    $quantity = $_POST['productQuantity'];
    $expiry = $_POST['Expirydate'];

    $product->addProduct($pname, $price, $quantity, $expiry);
} else {
    echo "Invalid request method";
}
?>
