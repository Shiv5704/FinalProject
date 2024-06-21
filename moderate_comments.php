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

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Access denied. Admins only.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = $_POST['comment_id'];
    $action = $_POST['action'];
    $moderated_by = $_SESSION['user_id'];

    if ($action == 'approve') {
        $sql = "UPDATE comments SET moderated=1, moderated_by=$moderated_by WHERE id=$comment_id";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM comments WHERE id=$comment_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Comment moderated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT comments.id, comments.content, comments.created_at, comments.moderated, users.username, pages.title 
        FROM comments 
        JOIN users ON comments.user_id = users.id 
        JOIN pages ON comments.page_id = pages.id 
        WHERE comments.moderated=0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Comments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Moderate Comments</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Content</th>
                    <th>Submitted By</th>
                    <th>Page Title</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["id"] . '</td>';
                        echo '<td>' . $row["content"] . '</td>';
                        echo '<td>' . $row["username"] . '</td>';
                        echo '<td>' . $row["title"] . '</td>';
                        echo '<td>' . $row["created_at"] . '</td>';
                        echo '<td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="comment_id" value="' . $row["id"] . '">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="comment_id" value="' . $row["id"] . '">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No comments to moderate</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
