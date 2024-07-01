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

    public function addPrescription($pname, $patientemail, $prescriptiontext) { // Corrected method name
        $stmt = $this->conn->prepare("INSERT INTO prescriptions (`patient_name`, `patient_email`, `prescription_text`) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Error in prepare: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $pname, $patientemail, $prescriptiontext); // Corrected parameter types

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

    $pname = $_POST['pname'];
    $patientemail = $_POST['pemail'];
    $prescriptiontext = $_POST['prescriptiontext'];
    $prescription->addPrescription($pname, $patientemail, $prescriptiontext); // Corrected method call
} else {
    echo "Invalid request method";
}
?>