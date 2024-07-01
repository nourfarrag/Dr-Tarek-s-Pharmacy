<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dr. tarek's pharmacy";
    public $conn;

    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        // Close connection
        $this->conn->close();
    }
}

class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function delete($productId) {
        // Prepare and execute delete statement
        $stmt = $this->conn->prepare("DELETE FROM products WHERE Product_ID = ?");
        $stmt->bind_param("i", $productId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
}

// Main script
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Data received from AJAX request
    $productId = isset($_POST['productId']) ? $_POST['productId'] : '';

    if (!empty($productId)) {
        // Initialize database and product objects
        $database = new Database();
        $product = new Product($database->conn);

        // Delete product
        if ($product->delete($productId)) {
            // Send success response
            http_response_code(200); // Set HTTP response code to 200 (OK)
            echo "Product deleted successfully";
        } else {
            // Send error response
            http_response_code(500); // Set HTTP response code to 500 (Internal Server Error)
            echo "Error deleting product";
        }
    } else {
        // Send error response for missing product ID
        http_response_code(400); // Set HTTP response code to 400 (Bad Request)
        echo "Invalid product ID";
    }
} else {
    // Invalid request method
    http_response_code(400); // Set HTTP response code to 400 (Bad Request)
    echo "Invalid request method";
}
?>
