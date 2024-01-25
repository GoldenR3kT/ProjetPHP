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
    <link rel="stylesheet" href="../../trashcan_icon.css">
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

<!-- Bouton pour changer de vue -->
<div class="manage-user-button button" style="position: absolute; top: 10px; left: 10px;">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="manage_users">AllUsers</button>
    </form>
</div>


<h1><a href="admin_home.php" id="home" style="text-decoration: none; color: red;">AdminGram</a></h1>
<div class="friends-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="friends"><i class="gg-user-list"></i></button>
    </form>
</div>
<div class="container">
    <h2>Posts</h2>

    <!-- Barre de recherche -->
    <form action="../../controllers/process.php" method="post">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" placeholder="Enter title or author">
        <button type="submit" name="search_button_posts_admin">Search</button>
    </form>


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


                <!-- Boutons Like, Dislike et Commentaire -->
                <div class="action-buttons">
                    <form action="../../controllers/process.php" method="post">
                        <input type="hidden" name="postId" value="<?php echo $post['IDpost']; ?>">
                        <button name="like" type="submit">Like</button>
                        <span><?php echo $post['aime']; ?></span>
                    </form>

                    <form action="../../controllers/process.php" method="post">
                        <button name="dislike" type="submit">Dislike</button>
                        <span>0</span>
                    </form>

                    <form action="../../controllers/process.php" method="post">
                        <button name="comment" type="submit">Commentaire</button>
                        <span>0</span>
                    </form>
                    <form action="../../controllers/process.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                        <input type="hidden" name="postId" value="<?php echo $post['IDpost']; ?>">
                        <div class="delete-button">
                        <button type="submit" name="delete_post">
                            <i class="gg-trash"></i>
                        </button>
                        </div>
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
                echo '<button type="submit" name="pagination_admin" value="' . $i . '" ' . $disabled . '>' . $i . '</button>';
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
