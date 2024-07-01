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
                                <th> Product Code </th>
                                <th> Product Name </th>
                                <th> Original Price </th>
                                <th> Price </th>
                                <th> Profit </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="product_code" required></td>
                                <td><input type="text" name="product_name" required></td>
                                <td><input type="number" name="orgprice" min="0" required></td>
                                <td><input type="number" name="price" min="0" required></td>
                                <td><input type="number" name="profit" min="0" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Insert</button>
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
        private $table_name = "orderpro";

        public $product_code;
        public $product_name;
        public $orgprice;
        public $price;
        public $profit;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            $query = "INSERT INTO " . $this->table_name . " 
                      SET productcode=:product_code, product_name=:product_name, orgprice=:orgprice, 
                          price=:price, profit=:profit";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':product_code', $this->product_code);
            $stmt->bindParam(':product_name', $this->product_name);
            $stmt->bindParam(':orgprice', $this->orgprice);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':profit', $this->profit);

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
        $salesOrder->product_code = $_POST['product_code'];
        $salesOrder->product_name = $_POST['product_name'];
        $salesOrder->orgprice = $_POST['orgprice'];
        $salesOrder->price = $_POST['price'];
        $salesOrder->profit = $_POST['profit'];

        if ($salesOrder->create()) {
            header("Location: sales.php");
            exit();
        } else {
            // Handle error
        }
    }
    ?>
</body>
</html>
