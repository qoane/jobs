<?php
// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recruitment";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    echo "Connected successfully";
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>