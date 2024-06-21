/*******w******** 
        
        Name: Shivkumar Lad
        Date: June 21, 2024
        Description:To View The Page

    ****************/
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

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$page_id = isset($_GET['id']) ? sanitize_input($_GET['id']) : 0;
if (!filter_var($page_id, FILTER_VALIDATE_INT)) {
    die("Invalid page ID");
}

$sql = "SELECT pages.title, pages.content, pages.image_path, pages.created_at, users.username AS author, categories.name AS category 
        FROM pages 
        JOIN users ON pages.created_by = users.id 
        LEFT JOIN categories ON pages.category_id = categories.id 
        WHERE pages.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $page_id);
$stmt->execute();
$result = $stmt->get_result();
$page = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title']); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5"><?php echo htmlspecialchars($page['title']); ?></h1>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($page['author']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($page['category']); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($page['created_at']); ?></p>
        <?php if ($page['image_path']): ?>
            <img src="<?php echo htmlspecialchars($page['image_path']); ?>" alt="Image" class="img-fluid mb-3">
        <?php endif; ?>
        <hr>
        <div><?php echo nl2br(htmlspecialchars($page['content'])); ?></div>
        <a href="list_pages.php" class="btn btn-secondary mt-3">Back to Pages</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
