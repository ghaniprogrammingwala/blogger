<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if config.php exists and is readable
if (!file_exists('config.php') || !is_readable('config.php')) {
    die("Error: config.php is missing or not readable");
}

require_once 'config.php';

// Check if the database connection is successful
if (!$pdo) {
    die("Error: Database connection failed");
}

session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user's blog posts
$stmt = $pdo->prepare("SELECT * FROM articles WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - My Blogger</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #FF5722;
            color: white;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        h1 {
            font-size: 24px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 1rem;
        }
        .create-post {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1rem;
        }
        .post-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        .post-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        .post-title {
            font-size: 20px;
            margin-bottom: 0.5rem;
        }
        .post-description {
            color: #666;
            margin-bottom: 1rem;
        }
        .post-actions {
            display: flex;
            justify-content: space-between;
        }
        .post-actions a {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            color: white;
        }
        .edit-post {
            background-color: #2196F3;
        }
        .delete-post {
            background-color: #f44336;
        }
        .no-posts {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="logout.php">Logout</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <a href="create_post.php" class="create-post">Create New Post</a>

        <section class="post-list">
            <?php if (empty($posts)): ?>
                <p class="no-posts">You haven't created any posts yet. Start blogging!</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p class="post-description"><?php echo htmlspecialchars(substr($post['description'], 0, 100)) . '...'; ?></p>
                        <div class="post-actions">
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="edit-post">Edit</a>
                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="delete-post" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
