<?php
$servername = "db"; // nama service MySQL di docker-compose.yml
$username = "annisa";
$password = "12345";
$database = "attendance_system";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
