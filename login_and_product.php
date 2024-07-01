<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dr. tarek's pharmacy"; // Database name
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


class ProductSubject {
    private $observers = [];
    private $lastProductName = '';

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function setLastProductName($productName) {
        $this->lastProductName = $productName;
        $this->notifyObservers();
    }

    private function notifyObservers() {
        foreach ($this->observers as $observer) {
            $observer->update($this->lastProductName);
        }
    }
}


interface Observer {
    public function update($data);
}


class LastProductObserver implements Observer {
    public function update($data) {
        echo '<div class="notification">Last product added: ' . $data . '</div>';
    }
}


$productSubject = new ProductSubject();
$lastProductObserver = new LastProductObserver();


$productSubject->attach($lastProductObserver);


$lastProductNameQuery = "SELECT Product_Name FROM products ORDER BY Product_ID DESC LIMIT 1";
$result = $conn->query($lastProductNameQuery);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastProductName = $row['Product_Name'];

    $productSubject->setLastProductName($lastProductName);
} else {
    echo "No products found.";
}

$conn->close();
?>
