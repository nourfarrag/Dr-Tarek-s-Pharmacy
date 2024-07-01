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
                        } catch (PDOException $exception) 
                        {
                            echo "Connection error: " . $exception->getMessage();
                        }

                        return $this->conn;
                    }
                }

                
                class SalesOrder {
                    private $conn;
                    private $table_name = "sales_order";

                    public $transaction_id;
                    public $product_code;
                    public $gen_name;
                    public $name;
                    public $price;
                    public $qty;
                    public $amount;
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
                                  SET product_code = :product_code, gen_name = :gen_name, name = :name, 
                                      price = :price, qty = :qty, amount = :amount, profit = :profit 
                                  WHERE transaction_id = :transaction_id";

                        $stmt = $this->conn->prepare($query);

                        $stmt->bindParam(':product_code', $this->product_code);
                        $stmt->bindParam(':gen_name', $this->gen_name);
                        $stmt->bindParam(':name', $this->name);
                        $stmt->bindParam(':price', $this->price);
                        $stmt->bindParam(':qty', $this->qty);
                        $stmt->bindParam(':amount', $this->amount);
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
                            $this->salesOrder->transaction_id = $_POST['product_id'];
                            $this->salesOrder->product_code = $_POST['product_code'];
                            $this->salesOrder->gen_name = $_POST['gen_name'];
                            $this->salesOrder->name = $_POST['name'];
                            $this->salesOrder->price = $_POST['price'];
                            $this->salesOrder->qty = $_POST['qty'];
                            $this->salesOrder->amount = $_POST['amount'];
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
                            <input type="hidden" name="product_id" value="<?php echo $product['transaction_id']; ?>">
                            <table class="custom-table" id="resultTable">
                                <thead>
                                    <tr>
                                        <th> Product Code </th>
                                        <th> Generic Name </th>
                                        <th> Name </th>
                                        <th> Price </th>
                                        <th> Qty </th>
                                        <th> Amount </th>
                                        <th> Profit </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="product_code" value="<?php echo $product['product_code']; ?>" required></td>
                                        <td><input type="text" name="gen_name" value="<?php echo $product['gen_name']; ?>" required></td>
                                        <td><input type="text" name="name" value="<?php echo $product['name']; ?>" required></td>
                                        <td><input type="number" name="price" value="<?php echo $product['price']; ?>" min="0" required></td>
                                        <td><input type="number" name="qty" value="<?php echo $product['qty']; ?>" min="0" required></td>
                                        <td><input type="number" name="amount" value="<?php echo $product['amount']; ?>" min="0" required></td>
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
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                 {

                    $formHandler->handlePostRequest();
                }
                 else
                {
                    $formHandler->handleGetRequest();
                }

                ?>
            </div>
        </div>
    </div>
</body>
</html>
