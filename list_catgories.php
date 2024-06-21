<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Categories</h1>
        <ul class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="list-group-item">';
                    echo '<a href="view_category.php?id=' . $row["id"] . '">' . $row["name"] . '</a>';
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">No categories found</li>';
            }
            ?>
        </ul>
        <a href="list_pages.php" class="btn btn-secondary mt-3">Back to Pages</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
