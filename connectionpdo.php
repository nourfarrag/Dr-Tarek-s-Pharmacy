<?php
$user='root';
$pass= '';
$db='dr. tarek\'s pharmacy';
$conn = new PDO("mysql:host=localhost;dbname=$db", "$user", "$pass");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>