/*******w******** 
        
        Name: Shivkumar Lad
        Date: June 21, 2024
        Description: To update A Page

    ****************/
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];

    $sql = "UPDATE pages SET title='$title', content='$content', category_id=$category_id, updated_at=NOW() WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Page updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
