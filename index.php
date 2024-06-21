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

// Get sort parameters from the URL, default to sorting by title
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';

// Validate sort column
$valid_columns = ['title', 'category', 'created_at'];
if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'title';
}

// Fetch pages from the database
$sql = "SELECT pages.id, pages.title, categories.name AS category, pages.created_at 
        FROM pages 
        LEFT JOIN categories ON pages.category_id = categories.id 
        ORDER BY $sort_column $sort_order";
$result = $conn->query($sql);

// Determine the new sort order for links
$new_sort_order = $sort_order == 'ASC' ? 'desc' : 'asc';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Pages</h1>
        <a href="create_page.html" class="btn btn-primary mb-3">Create New Page</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><a href="?sort=title&order=<?php echo $new_sort_order; ?>">Title</a></th>
                    <th><a href="?sort=category&order=<?php echo $new_sort_order; ?>">Category</a></th>
                    <th><a href="?sort=created_at&order=<?php echo $new_sort_order; ?>">Created At</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["title"] . '</td>';
                        echo '<td>' . $row["category"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '<td>
                                <a href="edit_page.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_page.php?id=' . $row["id"] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this page?\')">Delete</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No pages found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
