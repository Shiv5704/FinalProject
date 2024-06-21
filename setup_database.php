/*******w******** 
        
        Name: Shivkumar Lad
        Date: June 21, 2024
        Description: Code for database creation and inserting data.

    ****************/
<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "cms";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db($dbname);

// Create users table
$sql_create_users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'viewer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_users_table) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Insert sample data into users table
$sql_insert_users = "INSERT INTO users (username, password, role)
                    VALUES
                        ('admin', '" . password_hash('adminpassword', PASSWORD_DEFAULT) . "', 'admin'),
                        ('editor1', '" . password_hash('editor1password', PASSWORD_DEFAULT) . "', 'editor'),
                        ('editor2', '" . password_hash('editor2password', PASSWORD_DEFAULT) . "', 'editor'),
                        ('viewer1', '" . password_hash('viewer1password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('viewer2', '" . password_hash('viewer2password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('viewer3', '" . password_hash('viewer3password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('user1', '" . password_hash('user1password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('user2', '" . password_hash('user2password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('user3', '" . password_hash('user3password', PASSWORD_DEFAULT) . "', 'viewer'),
                        ('user4', '" . password_hash('user4password', PASSWORD_DEFAULT) . "', 'viewer')";

if ($conn->query($sql_insert_users) === TRUE) {
    echo "Sample users inserted successfully<br>";
} else {
    echo "Error inserting users: " . $conn->error . "<br>";
}

// Create categories table
$sql_create_categories_table = "CREATE TABLE IF NOT EXISTS categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_categories_table) === TRUE) {
    echo "Categories table created successfully<br>";
} else {
    echo "Error creating categories table: " . $conn->error . "<br>";
}

// Insert sample data into categories table
$sql_insert_categories = "INSERT INTO categories (name)
                          VALUES
                              ('Category 1'),
                              ('Category 2'),
                              ('Category 3'),
                              ('Category 4'),
                              ('Category 5'),
                              ('Category 6'),
                              ('Category 7'),
                              ('Category 8'),
                              ('Category 9'),
                              ('Category 10')";

if ($conn->query($sql_insert_categories) === TRUE) {
    echo "Sample categories inserted successfully<br>";
} else {
    echo "Error inserting categories: " . $conn->error . "<br>";
}

// Create pages table
$sql_create_pages_table = "CREATE TABLE IF NOT EXISTS pages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT(6) UNSIGNED,
    created_by INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
)";

if ($conn->query($sql_create_pages_table) === TRUE) {
    echo "Pages table created successfully<br>";
} else {
    echo "Error creating pages table: " . $conn->error . "<br>";
}

// Insert sample data into pages table
$sql_insert_pages = "INSERT INTO pages (title, content, category_id, created_by)
                     VALUES
                         ('Page 1', 'Content for Page 1', 1, 1),
                         ('Page 2', 'Content for Page 2', 2, 2),
                         ('Page 3', 'Content for Page 3', 3, 3),
                         ('Page 4', 'Content for Page 4', 4, 4),
                         ('Page 5', 'Content for Page 5', 5, 5),
                         ('Page 6', 'Content for Page 6', 6, 6),
                         ('Page 7', 'Content for Page 7', 7, 7),
                         ('Page 8', 'Content for Page 8', 8, 8),
                         ('Page 9', 'Content for Page 9', 9, 9),
                         ('Page 10', 'Content for Page 10', 10, 10)";

if ($conn->query($sql_insert_pages) === TRUE) {
    echo "Sample pages inserted successfully<br>";
} else {
    echo "Error inserting pages: " . $conn->error . "<br>";
}

// Create comments table
$sql_create_comments_table = "CREATE TABLE IF NOT EXISTS comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id INT(6) UNSIGNED,
    user_id INT(6) UNSIGNED,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    moderated TINYINT(1) DEFAULT 0,
    moderated_by INT(6) UNSIGNED,
    FOREIGN KEY (page_id) REFERENCES pages(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (moderated_by) REFERENCES users(id)
)";

if ($conn->query($sql_create_comments_table) === TRUE) {
    echo "Comments table created successfully<br>";
} else {
    echo "Error creating comments table: " . $conn->error . "<br>";
}

// Insert sample data into comments table
$sql_insert_comments = "INSERT INTO comments (page_id, user_id, content, moderated, moderated_by)
                        VALUES
                            (1, 2, 'Comment on Page 1', 0, NULL),
                            (2, 3, 'Comment on Page 2', 0, NULL),
                            (3, 4, 'Comment on Page 3', 0, NULL),
                            (4, 5, 'Comment on Page 4', 0, NULL),
                            (5, 6, 'Comment on Page 5', 0, NULL),
                            (6, 7, 'Comment on Page 6', 0, NULL),
                            (7, 8, 'Comment on Page 7', 0, NULL),
                            (8, 9, 'Comment on Page 8', 0, NULL),
                            (9, 10, 'Comment on Page 9', 0, NULL),
                            (10, 1, 'Comment on Page 10', 0, NULL)";

if ($conn->query($sql_insert_comments) === TRUE) {
    echo "Sample comments inserted successfully<br>";
} else {
    echo "Error inserting comments: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>
