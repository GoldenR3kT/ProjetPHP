<!-- app/views/social/profile.php -->
<?php
session_start();

// Vous devrez inclure vos fichiers PHP nécessaires ici, tels que les scripts de traitement
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
<h1><a href="home.php" id="home" style="text-decoration: none; color: black;">MyGram</a></h1>
<div class="friends-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="friends"><i class="gg-user-list"></i></button>
    </form>
</div>
<div class="container">

    <div class="container">
        <h2>Modifier le Profil</h2>

        <!-- Formulaire de modification de profil -->
        <form action="../../controllers/process.php" method="post" enctype="multipart/form-data">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" required>

            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

            <label for="password">Nouveau mot de passe:</label>
            <input type="password" id="password" name="password">

            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <!-- Ajout du champ pour le téléchargement de la photo de profil -->
            <label for="profile_image">Changer la photo de profil:</label>
            <input type="file" id="profile_image" name="profile_image">

            <button type="submit" name="update_profile">Mettre à Jour le Profil</button>
        </form>
    </div>

</body>
</html>
