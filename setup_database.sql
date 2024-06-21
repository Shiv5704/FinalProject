-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS cms;

-- Use the database
USE cms;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'viewer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data into users table
INSERT INTO users (username, password, role)
VALUES
    ('admin', 'adminpassword', 'admin'),
    ('editor1', 'editor1password', 'editor'),
    ('editor2', 'editor2password', 'editor'),
    ('viewer1', 'viewer1password', 'viewer'),
    ('viewer2', 'viewer2password', 'viewer'),
    ('viewer3', 'viewer3password', 'viewer'),
    ('user1', 'user1password', 'viewer'),
    ('user2', 'user2password', 'viewer'),
    ('user3', 'user3password', 'viewer'),
    ('user4', 'user4password', 'viewer');

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data into categories table
INSERT INTO categories (name)
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
    ('Category 10');

-- Create pages table
CREATE TABLE IF NOT EXISTS pages (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category_id INT(6) UNSIGNED,
    created_by INT(6) UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert sample data into pages table
INSERT INTO pages (title, content, category_id, created_by)
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
    ('Page 10', 'Content for Page 10', 10, 10);

-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
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
);

-- Insert sample data into comments table
INSERT INTO comments (page_id, user_id, content, moderated, moderated_by)
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
    (10, 1, 'Comment on Page 10', 0, NULL);
