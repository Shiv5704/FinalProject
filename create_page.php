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

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty($_POST["title"])) {
        $errors[] = "Title is required";
    } else {
        $title = sanitize_input($_POST["title"]);
        if (strlen($title) > 255) {
            $errors[] = "Title must be less than 255 characters";
        }
    }

    // Validate content
    if (empty($_POST["content"])) {
        $errors[] = "Content is required";
    } else {
        $content = sanitize_input($_POST["content"]);
    }

    // Validate category_id
    if (isset($_POST["category_id"])) {
        $category_id = sanitize_input($_POST["category_id"]);
        if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
            $errors[] = "Invalid category ID";
        }
    } else {
        $category_id = NULL;
    }

    // Validate and handle image upload
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size (limit to 2MB)
        if ($_FILES["image"]["size"] > 2000000) {
            $errors[] = "Image file is too large. Maximum size is 2MB.";
        }

        // Allow only certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $errors[] = "There was an error uploading your image.";
            }
        }
    } else {
        $image_path = NULL;
    }

    if (empty($errors)) {
        $created_by = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO pages (title, content, category_id, created_by, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $title, $content, $category_id, $created_by, $image_path);
        
        if ($stmt->execute()) {
            echo "New page created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Create Page</h1>
        <form action="create_page.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <!-- Populate with categories -->
                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create Page</button>
        </form>
        <a href="list_pages.php" class="btn btn-secondary mt-3">Back to Pages</a>
    </div>
</body>
</html>
