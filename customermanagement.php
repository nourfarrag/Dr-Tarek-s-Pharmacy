<?php
class CustomerManagement {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dr. tarek's pharmacy"; // Avoid spaces in database names

    private $conn;

    // Constructor to establish database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } 
    }

    // Method to add a new customer
    public function insertCustomer($fullName, $address, $contact, $productName, $total, $note, $expectedDate) {
        $sql = "INSERT INTO customers (FullName, Address, Contact, ProductName, Total, Note, ExpectedDate) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $fullName, $address, $contact, $productName, $total, $note, $expectedDate);

        if ($stmt->execute()) {
            $customerId = $this->conn->insert_id;
            echo "New record created successfully. Customer ID: " . $customerId;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $stmt->close();
    }

    // Method to fetch and display customer data
    public function displayCustomers() {
        $sql = "SELECT CustomerId, FullName, Address, Contact FROM customers";
        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table id='customerTable'>";
                echo "<thead><tr><th>ID</th><th>Name</th><th>Address</th><th>Contact</th><th>Action</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["CustomerId"] . "</td>";
                    echo "<td>" . $row["FullName"] . "</td>";
                    echo "<td>" . $row["Address"] . "</td>";
                    echo "<td>" . $row["Contact"] . "</td>";
                    echo "<td>
                            <button class='update' onclick='editCustomer(this)'>Update</button>
                            <button class='delete' onclick='deleteCustomer(this)'>Delete</button>
                          </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "No data found";
            }
        } else {
            echo "Error executing SQL query: " . mysqli_error($this->conn);
        }
    }

    // Method to update customer data
    public function updateCustomerData($customerId, $new_name, $new_address, $new_contact) {
        $stmt = $this->conn->prepare("UPDATE customers SET FullName=?, Address=?, Contact=? WHERE CustomerId=?");
        if (!$stmt) {
            echo "Error preparing statement: " . $this->conn->error;
            exit;
        }

        $stmt->bind_param("sssi", $new_name, $new_address, $new_contact, $customerId);
        if ($stmt->execute()) {
            echo "Customer data updated successfully";
        } else {
            echo "Error updating customer data: " . $stmt->error;
        }

        $stmt->close();
    }

    // Method to delete a customer
    public function deleteCustomer($customerId) {
        $stmt = $this->conn->prepare("DELETE FROM customers WHERE CustomerId=?");
        $stmt->bind_param("i", $customerId);

        if ($stmt->execute()) {
            echo "Customer with ID $customerId deleted successfully";
        } else {
            echo "Error deleting customer: " . $stmt->error;
        }

        $stmt->close();
    }

    // Destructor to close the database connection
    public function __destruct() {
        mysqli_close($this->conn);
    }
}

// Usage example
$customerManagement = new CustomerManagement();

// Call methods based on request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $customerManagement->insertCustomer($_POST["name"], $_POST["address"], $_POST["contact"], $_POST["prod_name"], $_POST["memno"], $_POST["note"], $_POST["date"]);
    } elseif (isset($_POST["update"])) {
        $customerManagement->updateCustomerData($_POST["CustomerId"], $_POST["new_name"], $_POST["new_address"], $_POST["new_contact"]);
    } elseif (isset($_POST["delete"])) {
        $customerManagement->deleteCustomer($_POST["CustomerId"]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $customerManagement->displayCustomers();
}
?>
