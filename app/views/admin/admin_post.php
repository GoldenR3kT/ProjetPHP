<!-- app/views/posts/commentaires.php -->
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
        <button type="submit" name="profile"><i class="gg-profile"></i></button>
    </form>
</div>
<div class="logout-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="logout"><i class="gg-log-out"></i></button>
    </form>
</div>

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


<!-- Afficher le post -->
<div class="container">

    <h3><?php
        $post = $_SESSION['post'];
        echo $post['titre']; ?></h3>

    <?php if ($post['Img']): ?>
        <img class="post-image" src="../../../uploads/<?php echo $post['Img']; ?>" alt="Post Photo">
    <?php endif; ?>


    <p><?php echo $post['Message']; ?></p>

    <p>Visibilité: <?php echo $post['visibilite']; ?></p>

    <p>Posté par: <?php echo $post['author'];?></p>

    <p>Date: <?php echo $post['date_post']; ?></p>


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

    </div>
</div>


<!-- Afficher les commentaires -->
<div class="container">
    <h2>Commentaires</h2>
    <?php
    $comments = $_SESSION['comments'];
    foreach ($comments as $comment): ?>
        <div class="comment">
            <h3><?php echo $comment['auteur']; ?>:</h3>
            <p><?php echo $comment['commentaire']; ?></p>
        </div>
    <?php endforeach; ?>

    <!-- Ajouter un formulaire pour permettre aux utilisateurs d'ajouter des commentaires -->
    <form action="../../controllers/process.php" method="post">
        <input type="hidden" name="postId" value="<?php echo $post['IDpost']; ?>">
        <textarea name="commentaire" placeholder="Ajouter un commentaire"></textarea>
        <button type="submit" name="admin_addComment">Ajouter un commentaire</button>
    </form>
</div>
<!-- Ajouter des liens ou des boutons pour revenir à la page précédente si nécessaire -->

</body>
</html>
