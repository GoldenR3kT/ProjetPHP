<!-- app/views/posts/index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="container">
    <h2>Posts</h2>

    <?php
    foreach ($posts as $post): ?>
        <div class="post">
            <h3><?php echo $post->title; ?></h3>

            <?php if ($post->photo): ?>
                <img src="/uploads/<?php echo $post->photo; ?>" alt="Post Photo">
            <?php endif; ?>

            <p><?php echo $post->content; ?></p>

            <p>Visibility: <?php echo $post->visibility; ?></p>

            <p>Created at: <?php echo $post->created_at; ?></p>
        </div>
    <?php endforeach; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/posts?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

    <p><a href="./create.php">Create a new post</a></p>
</div>

</body>
</html>
