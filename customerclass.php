<?php
include_once 'userclass.php';

class Customer extends User
{
    public function register($firstName, $middleInitial, $lastName, $email, $password, $dob, $repeatPassword)
    {
        // Validate input
        if ($password !== $repeatPassword) {
            echo "Passwords do not match!";
            return false;
        }

        // Sanitize input data
        $firstName = $this->conn->real_escape_string($firstName);
        $middleInitial = $this->conn->real_escape_string($middleInitial);
        $lastName = $this->conn->real_escape_string($lastName);
        $email = $this->conn->real_escape_string($email);
        $dob = $this->conn->real_escape_string($dob);

        // Check if email already exists
        $sql = "SELECT * FROM login WHERE email=?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "Email already exists!";
                return false;
            }
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO login (first_name, middle_initial, last_name, email, password, dob) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param('ssssss', $firstName, $middleInitial, $lastName, $email, $hashedPassword, $dob);

            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error: " . $this->conn->error;
                return false;
            }
        } else {
            echo "Error: " . $this->conn->error;
            return false;
        }
    }
}

// Initialize the Customer object and pass the connection
$customer = new Customer($conn);

// Get the values from the POST array
$firstName = $_POST["first-name"];
$middleInitial = $_POST["middle-initial"];
$lastName = $_POST["last-name"];
$email = $_POST["email"];
$password = $_POST["password"];
$dob = $_POST["dob"];
$repeatPassword = $_POST["repeat-password"];

// Now you can call the register method on the $customer object
$registrationSuccessful = $customer->register($firstName, $middleInitial, $lastName, $email, $password, $dob, $repeatPassword);

if ($registrationSuccessful) {
    echo "Registration successful!";
} else {
    echo "Registration failed!";
}
?>
