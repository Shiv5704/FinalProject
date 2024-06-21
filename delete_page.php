<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$page_id = $_GET['id'];

$sql = "DELETE FROM pages WHERE id=$page_id";

if ($conn->query($sql) === TRUE) {
    echo "Page deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
