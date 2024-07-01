<?php
class Pharmacy {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect() {
        // Enable error reporting
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insertCustomer($fullName, $address, $contact, $productName, $total, $note, $expectedDate) {
        // Prepare and bind SQL statement
        $sql = "INSERT INTO customers (FullName, Address, Contact, ProductName, Total, Note, ExpectedDate) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $fullName, $address, $contact, $productName, $total, $note, $expectedDate);

        // Execute SQL statement
        if ($stmt->execute()) {
            $customerId = $this->conn->insert_id; // Get the ID of the inserted record
            echo "New record created successfully. Customer ID: " . $customerId;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        // Close statement
        $stmt->close();
    }

    public function closeConnection() {
        // Close the database connection
        $this->conn->close();
    }
}

// Usage
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dr. tarek's pharmacy";

$pharmacy = new Pharmacy($servername, $username, $password, $dbname);
$pharmacy->connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = mysqli_real_escape_string($pharmacy->conn, $_POST["name"]);
    $address = mysqli_real_escape_string($pharmacy->conn, $_POST["address"]);
    $contact = mysqli_real_escape_string($pharmacy->conn, $_POST["contact"]);
    $productName = mysqli_real_escape_string($pharmacy->conn, $_POST["prod_name"]);
    $total = mysqli_real_escape_string($pharmacy->conn, $_POST["memno"]);
    $note = mysqli_real_escape_string($pharmacy->conn, $_POST["note"]);
    $expectedDate = mysqli_real_escape_string($pharmacy->conn, $_POST["date"]);

    $pharmacy->insertCustomer($fullName, $address, $contact, $productName, $total, $note, $expectedDate);
}

$pharmacy->closeConnection();
?>
