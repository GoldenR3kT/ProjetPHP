<!-- app/views/posts/index.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... autres balises head ... -->
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../friends_icon.css">
    <link rel="stylesheet" href="../../logout_icon.css">
    <link rel="stylesheet" href="../../profil_icon.css">
</head>
<body>
<div class="profile-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="logout"><i class="gg-profile"></i></button>
    </form>
</div>
<div class="logout-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="logout"><i class="gg-log-out"></i></button>
    </form>
</div>
<h1><a href="home.php" id="home" style="text-decoration: none; color: black;">MyGram</a></h1>
<div class="friends-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="friends"><i class="gg-user-list"></i></button>
    </form>
</div>
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
                    <img src="../../../uploads/<?php echo $post['Img']; ?>" alt="Post Photo">
                <?php endif; ?>

                <p><?php echo $post['Message']; ?></p>

                <p>Visibilité: <?php echo $post['visibilite']; ?></p>

                <p>Posté par: <?php echo $post['author'];?></p>


                <p>Date: <?php echo $post['created_at']; ?></p>

                <?php print_r($post)?>

                <!-- Boutons Like, Dislike et Commentaire -->
                <div class="action-buttons">
                    <form action="../../controllers/process.php" method="post">
                        <input type="hidden" name="postId" value="<?php echo $post['IDpost']; ?>">
                        <button name="like" type="submit">Like</button>
                        <span><?php echo $post['aime']; ?></span>
                    </form>

                    <form action="../../controllers/process.php" method="post">
                        <input type="hidden" name="postId" value="<?php echo $post['IDpost']; ?>">
                        <button name="dislike" type="submit">Dislike</button>
                        <span><?php echo $post['aimePas']; ?></span>
                    </form>

                    <form action="../../controllers/process.php" method="post">
                        <button name="comment" type="submit">Commentaire</button>
                        <span>0</span>
                    </form>
                </div>
            </div>
        <?php endforeach;
    } else {
        echo "<p>No posts available.</p>";
    }

    ?>

    <div class="pagination">
        <?php
        // Vérifier si la variable $totalPages est définie dans la session
        if (isset($_SESSION['totalPages'])) {
            $totalPages = $_SESSION['totalPages'];

            // Utilisez un seul formulaire pour tous les boutons de pagination
            echo '<form action="../../controllers/process.php" method="post">';

            // Boucle pour générer les liens de pagination
            for ($i = 1; $i <= $totalPages; $i++) {
                $disabled = ($i == $_SESSION['currentPage']) ? 'disabled' : '';
                echo '<button type="submit" name="pagination" value="' . $i . '" ' . $disabled . '>' . $i . '</button>';
            }

            echo '</form>';
        }
        ?>
    </div>


    <form action="../../controllers/process.php" method="post">
        <button name="new_post" type="submit">Créer un nouveau post</button>
    </form>
</div>

</body>
</html>
