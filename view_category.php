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

$category_id = $_GET['id'];
$sql = "SELECT pages.id, pages.title, users.username AS author, pages.created_at 
        FROM pages 
        JOIN users ON pages.created_by = users.id 
        WHERE pages.category_id = $category_id 
        ORDER BY pages.created_at DESC";
$result = $conn->query($sql);

$category_sql = "SELECT name FROM categories WHERE id = $category_id";
$category_result = $conn->query($category_sql);
$category = $category_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages in Category: <?php echo $category['name']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Pages in Category: <?php echo $category['name']; ?></h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
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
                        echo '<td>' . $row["title"] . '</td>';
                        echo '<td>' . $row["author"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '<td><a href="view_page.php?id=' . $row["id"] . '" class="btn btn-primary btn-sm">View</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No pages found in this category</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="list_categories.php" class="btn btn-secondary mt-3">Back to Categories</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
