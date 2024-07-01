<?php
session_start();
require_once 'connection.php';

class User
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);

        $sql = "SELECT * FROM login WHERE email=? AND password=?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param('ss', $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $email;
                $_SESSION['isdoctor'] = $row['isdoctor']; // Storing isdoctor in session

                // Redirect based on isdoctor value
                if ($row['isdoctor'] == 1) {
                    header("Location: home.html");
                } else {
                    header("Location: CustomerHomepage.php");
                }
                exit();
            }
        }
        return false;
    }
}
?>
