<!DOCTYPE html>
<html>
<head>
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="sales.css"> <!-- Link to your custom CSS file -->
</head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="contentheader">
                    <i class="icon-money"></i> Sales
                </div>
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                 
                    <table class="custom-table" id="resultTable">
                        <thead>
                            <tr>
                                <th>Supplier_Name</th>
                                <th>Supplier_Email</th>
                                <th>Supplier_Phone</th>
                                <th>Supplier_Address</th>
                                <th>Supplier_Pay_Terms</th>
                                <th>Supplier_id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            
                                <td><input type="text" name="supplier_name" required></td>
                                <td><input type="text" name="supplier_email" required></td>
                                <td><input type="text" name="supplier_phone" required></td>
                                <td><input type="text" name="supplier_address" required></td>
                                <td><input type="text" name="supplier_pay_terms" required></td>
                                <td><input type="number" name="supplier_id" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    class Database {
        private $host = 'localhost';
        private $db_name = 'dr. tarek\'s pharmacy';
        private $username = 'root';
        private $password = '';
        public $conn;

        public function getConnection() {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }

    class SalesOrder {
        private $conn;
        private $table_name = "suppliers";

        public $supplier_id;
        public $supplier_name;
        public $supplier_email;
        public $supplier_phone;
        public $supplier_address;
        public $supplier_pay_terms;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            $query = "INSERT INTO " . $this->table_name . " 
                      SET Supplier_Name=:supplier_name, Supplier_Email=:supplier_email, 
                          Supplier_Phone=:supplier_phone, Supplier_Address=:supplier_address, Supplier_Pay_Terms=:supplier_pay_terms";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':supplier_name', $this->supplier_name);
            $stmt->bindParam(':supplier_email', $this->supplier_email);
            $stmt->bindParam(':supplier_phone', $this->supplier_phone);
            $stmt->bindParam(':supplier_address', $this->supplier_address);
            $stmt->bindParam(':supplier_pay_terms', $this->supplier_pay_terms);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        }

        public function update() {
            $query = "UPDATE " . $this->table_name . " 
                      SET Supplier_Name=:supplier_name, Supplier_Email=:supplier_email, 
                          Supplier_Phone=:supplier_phone, Supplier_Address=:supplier_address, Supplier_Pay_Terms=:supplier_pay_terms 
                      WHERE SupplierID=:supplier_id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':supplier_id', $this->supplier_id);
            $stmt->bindParam(':supplier_name', $this->supplier_name);
            $stmt->bindParam(':supplier_email', $this->supplier_email);
            $stmt->bindParam(':supplier_phone', $this->supplier_phone);
            $stmt->bindParam(':supplier_address', $this->supplier_address);
            $stmt->bindParam(':supplier_pay_terms', $this->supplier_pay_terms);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        }
    }

    // Form handling
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $database = new Database();
        $db = $database->getConnection();

        $salesOrder = new SalesOrder($db);
        $salesOrder->supplier_id = $_POST['supplier_id'];
        $salesOrder->supplier_name = $_POST['supplier_name'];
        $salesOrder->supplier_email = $_POST['supplier_email'];
        $salesOrder->supplier_phone = $_POST['supplier_phone'];
        $salesOrder->supplier_address = $_POST['supplier_address'];
        $salesOrder->supplier_pay_terms = $_POST['supplier_pay_terms'];

        if (!empty($salesOrder->supplier_id)) {
            if ($salesOrder->update()) {
                echo "Record updated successfully.";
            } else {
                echo "Unable to update the record.";
            }
        } else {
            if ($salesOrder->create()) {
                echo "Record inserted successfully.";
            } else {
                echo "Unable to insert the record.";
            }
        }
    }
    ?>
</body>
</html>
