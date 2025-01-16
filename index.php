<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blogger</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            color: #FF5722;
            text-decoration: none;
            font-weight: bold;
        }

        .nav-buttons a {
            padding: 8px 16px;
            text-decoration: none;
            color: #666;
            margin-left: 10px;
        }

        .nav-buttons .sign-in {
            background-color: #FF5722;
            color: white;
            border-radius: 4px;
        }

        .hero {
            background-color: #45B7AF;
            color: white;
            text-align: center;
            padding: 4rem 2rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .create-blog-btn {
            background-color: #FF5722;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 2rem;
        }

        .blog-posts {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .blog-post {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .blog-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .blog-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .blog-excerpt {
            color: #444;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .read-more {
            color: #FF5722;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo">My Blogger</a>
        <nav class="nav-buttons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php" class="sign-in">Sign In</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero">
        <h1>Publish your passions, your way</h1>
        <p>Create a unique and beautiful blog easily.</p>
        <button class="create-blog-btn" onclick="window.location.href='<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php'; ?>'">
            CREATE YOUR BLOG
        </button>
    </section>

    <main class="blog-posts">
        <?php
        $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
        while($post = $stmt->fetch()) {
        ?>
            <article class="blog-post">
                <h2 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                <div class="blog-meta">
                    By <?php echo htmlspecialchars($post['username']); ?> | 
                    <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                </div>
                <p class="blog-excerpt">
                    <?php echo substr(htmlspecialchars($post['content']), 0, 200) . '...'; ?>
                </p>
                <a href="post.php?id=<?php echo $post['id']; ?>" class="read-more">Read More</a>
            </article>
        <?php
        }
        ?>
    </main>

    <script>
        document.querySelector('.create-blog-btn').addEventListener('click', function() {
            window.location.href = '<?php echo isset($_SESSION['user_id']) ? "dashboard.php" : "login.php"; ?>';
        });
    </script>
</body>
</html>
