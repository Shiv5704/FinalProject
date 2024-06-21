/*******w******** 
        
        Name: Shivkumar Lad
        Date: June 21, 2024
        Description: To Edit A Page

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

$page_id = $_GET['id'];

// Fetch page details
$page_result = $conn->query("SELECT * FROM pages WHERE id=$page_id");
$page = $page_result->fetch_assoc();

// Fetch categories
$categories_result = $conn->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Page</h1>
        <form action="update_page.php" method="post">
            <input type="hidden" name="id" value="<?php echo $page['id']; ?>">
            <div class="form-group">
                <label for="title">Page Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $page['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Page Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo $page['content']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    <?php
                    if ($categories_result->num_rows > 0) {
                        while ($row = $categories_result->fetch_assoc()) {
                            $selected = ($row["id"] == $page["category_id"]) ? 'selected' : '';
                            echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["name"] . '</option>';
                        }
                    } else {
                        echo '<option value="">No categories available</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Page</button>
        </form>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
