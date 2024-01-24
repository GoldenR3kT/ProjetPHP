<!-- app/views/posts/index.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... autres balises head ... -->
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

<div class="container">
    <h2>Posts</h2>

    <?php
    // Vérifier si la variable $posts est définie dans la session
    if (isset($_SESSION['posts'])) {
        $posts = $_SESSION['posts'];
        foreach ($posts as $post): ?>
            <div class="post">
                <h3><?php echo $post['titre']; ?></h3>

                <?php if ($post['Img']): ?>
                    <img src="/uploads/<?php echo $post['Img']; ?>" alt="Post Photo">
                <?php endif; ?>

                <p><?php echo $post['Message']; ?></p>

                <p>Visibility: <?php echo $post['visibilite']; ?></p>

                <p>Created at: <?php echo $post['created_at']; ?></p>
            </div>
        <?php endforeach;
    } else {
    echo "<p>No posts available.</p>";
    }
    ?>


    <p><a href="./create.php">Create a new post</a></p>
</div>

</body>
</html>
