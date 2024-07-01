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
                    <i class="icon-money"></i> Edit Product
                </div>
                <div style="margin-top: -19px; margin-bottom: 21px;"></div>
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

                    public $transaction_id;
                    public $productcode;
                    public $product_name;
                    public $orgprice;
                    public $price;
                    public $profit;

                    public function __construct($db) {
                        $this->conn = $db;
                    }

                    public function getById($id) {
                        $query = "SELECT * FROM " . $this->table_name . " WHERE transaction_id = :id";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();

                        return $stmt->fetch(PDO::FETCH_ASSOC);
                    }

                    public function update() {
                        $query = "UPDATE " . $this->table_name . " 
                                  SET productcode = :productcode, product_name = :product_name, orgprice = :orgprice, 
                                      price = :price, profit = :profit 
                                  WHERE transaction_id = :transaction_id";

                        $stmt = $this->conn->prepare($query);

                        $stmt->bindParam(':productcode', $this->productcode);
                        $stmt->bindParam(':product_name', $this->product_name);
                        $stmt->bindParam(':orgprice', $this->orgprice);
                        $stmt->bindParam(':price', $this->price);
                        $stmt->bindParam(':profit', $this->profit);
                        $stmt->bindParam(':transaction_id', $this->transaction_id);

                        return $stmt->execute();
                    }
                }

                class FormHandler {
                    private $db;
                    private $salesOrder;

                    public function __construct() {
                        $database = new Database();
                        $this->db = $database->getConnection();
                        $this->salesOrder = new SalesOrder($this->db);
                    }

                    public function handleGetRequest() {
                        if (isset($_GET['id'])) {
                            $product_id = $_GET['id'];
                            $product = $this->salesOrder->getById($product_id);

                            if ($product) {
                                $this->renderForm($product);
                            } else {
                                echo "Product not found.";
                            }
                        } else {
                            echo "Product ID is missing.";
                        }
                    }

                    public function handlePostRequest() {
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $this->salesOrder->transaction_id = $_POST['transaction_id'];
                            $this->salesOrder->productcode = $_POST['productcode'];
                            $this->salesOrder->product_name = $_POST['product_name'];
                            $this->salesOrder->orgprice = $_POST['orgprice'];
                            $this->salesOrder->price = $_POST['price'];
                            $this->salesOrder->profit = $_POST['profit'];

                            if ($this->salesOrder->update()) {
                                header("Location: sales.php");
                                exit();
                            } else {
                                echo "Error: ";
                            }
                        }
                    }

                    private function renderForm($product) {
                        ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="transaction_id" value="<?php echo $product['transaction_id']; ?>">
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
                                        <td><input type="text" name="productcode" value="<?php echo $product['productcode']; ?>" required></td>
                                        <td><input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required></td>
                                        <td><input type="number" name="orgprice" value="<?php echo $product['orgprice']; ?>" min="0" required></td>
                                        <td><input type="number" name="price" value="<?php echo $product['price']; ?>" min="0" required></td>
                                        <td><input type="number" name="profit" value="<?php echo $product['profit']; ?>" min="0" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                        <?php
                    }
                }

                $formHandler = new FormHandler();
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $formHandler->handlePostRequest();
                } else {
                    $formHandler->handleGetRequest();
                }

                ?>
            </div>
        </div>
    </div>
</body>
</html>
