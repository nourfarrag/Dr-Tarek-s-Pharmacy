<!DOCTYPE html>
<html>
<head>
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="sales.css"> 
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="contentheader">
                    <i class="icon-money"></i> Delete Supplier
                </div>
                <div style="margin-top: -19px; margin-bottom: 21px;"></div>
                <?php

                class Database {
                    private $conn;
                    public function getConnection() {
                        try {
                            $this->conn = new PDO("mysql:host=localhost;dbname=dr. tarek's pharmacy", "root", "");
                            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch (PDOException $e) {
                            echo "Connection error: " . $e->getMessage();
                        }
                        return $this->conn;
                    }
                }

                class Supplier {
                    private $conn;
                    public $Supplier_Name;
                    public function __construct($db) {
                        $this->conn = $db;
                    }
                    public function delete() {
                        if ($this->conn) {
                            $stmt = $this->conn->prepare("DELETE FROM suppliers WHERE Supplier_Name = :Supplier_Name");
                            $stmt->bindParam(':Supplier_Name', $this->Supplier_Name);
                            $stmt->execute();
                            return $stmt->rowCount() > 0;
                        } else {
                            echo "Database connection not established.";
                            return false;
                        }
                    }
                }

                class FormHandler {
                    private $db, $supplier;
                    public function __construct() {
                        $this->db = (new Database())->getConnection();
                        if ($this->db) {
                            $this->supplier = new Supplier($this->db);
                        } else {
                            echo "Failed to connect to the database.";
                        }
                    }
                    public function handleRequest() {
                        if (isset($_POST['Supplier_Name']) && !empty($_POST['Supplier_Name'])) {
                            $this->supplier->Supplier_Name = htmlspecialchars($_POST['Supplier_Name']);
                            if ($this->supplier->delete()) {
                                header("Location: Suppliers.php");
                                exit();
                            } else {
                                echo "Error deleting supplier.";
                            }
                        } else {
                            echo "Please enter a supplier name.";
                        }
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $formHandler = new FormHandler();
                    $formHandler->handleRequest();
                }

                ?>

                <form method="POST" action="">
                    <label for="Supplier_Name">Supplier Name:</label>
                    <input type="text" id="Supplier_Name" name="Supplier_Name" required>
                    <button type="submit">Delete Supplier</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
