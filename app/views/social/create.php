<!-- app/views/posts/create.php -->
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
    <h2>Créer un post</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="../../controllers/process.php" enctype="multipart/form-data">
        <p>
            <label for="title">Titre:</label>
            <input type="text" name="title" required>
        </p>

        <p>
            <label for="photo">Photo:</label>
            <input type="file" name="photo" accept="image/*">
        </p>

        <p>
            <label for="content">Description:</label>
            <textarea name="content" rows="4" required></textarea>
        </p>

        <p>
            <label for="visibility">Visibilité:</label>
            <select name="visibility">
                <option value="friends">Amis</option>
                <option value="public">Publique</option>
            </select>
        </p>
        <button name="poster" type="submit">Créer un post</button>
    </form>

    <p><a href="./home.php">Revenir a l'accueil</a></p>
</div>

</body>
</html>
