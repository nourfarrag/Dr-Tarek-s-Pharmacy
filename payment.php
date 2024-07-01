<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dr. tarek's pharmacy"; // Corrected database name
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

class Prescription { // Corrected class name
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function addPrescription($cardHolder, $cardNumber, $expiryDate,$cvc) { // Corrected method name
        $stmt = $this->conn->prepare("INSERT INTO payment (`cardHolder`, `cardNumber`, `expiryDate`,`cvc`) VALUES (?, ?, ?,?)");
        if (!$stmt) {
            die("Error in prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ssss", $cardHolder, $cardNumber, $expiryDate,$cvc); // Corrected parameter types

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
    $prescription = new Prescription($db); // Corrected class instantiation
    $cardHolder = $_POST['cardHolder'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvc = $_POST['cvc'];
    $prescription->addPrescription($cardHolder, $cardNumber, $expiryDate,$cvc); // Corrected method call
} else {
    echo "Invalid request method";
}
?>