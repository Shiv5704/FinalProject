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

$sql = "SELECT pages.id, pages.title, pages.image_path, users.username AS author, pages.created_at 
        FROM pages 
        JOIN users ON pages.created_by = users.id 
        ORDER BY pages.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Pages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">List of Pages</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row["title"]) . '</td>';
                        echo '<td>';
                        if ($row["image_path"]) {
                            echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="Image" class="img-thumbnail" style="max-width: 100px;">';
                        }
                        echo '</td>';
                        echo '<td>' . htmlspecialchars($row["author"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["created_at"]) . '</td>';
                        echo '<td><a href="view_page.php?id=' . $row["id"] . '" class="btn btn-primary btn-sm">View</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No pages found</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="create_page.php" class="btn btn-success mt-3">Create New Page</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
