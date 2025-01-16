<?php
$host = "localhost";
$dbname = "dbmocy0yvyrkon";
$username = "u1j5hu8arjzak";
$password = "kxyrgs6izs1y";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create comments table (now acting as posts)
    $conn->exec("CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Tables created successfully<br>";

    // Insert sample data
    // Insert a user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute(['johndoe', 'john@example.com', password_hash('password123', PASSWORD_DEFAULT)]);
    $userId = $conn->lastInsertId();

    // Insert a comment (now acting as a post)
    $stmt = $conn->prepare("INSERT INTO comments (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([
        $userId,
        'My First Blog Post',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
    ]);

    echo "Sample data inserted successfully";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
