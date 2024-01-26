<!-- admin_view.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <link rel="stylesheet" href="../../style.css">
        <link rel="stylesheet" href="../../friends_icon.css">
        <link rel="stylesheet" href="../../logout_icon.css">
        <link rel="stylesheet" href="../../profil_icon.css">
        <link rel="stylesheet" href="../../trashcan_icon.css">
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

<div class="manage-user-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="manage_users">Utilisateurs</button>
    </form>
</div>

<h1><a href="admin_home.php" id="home" style="text-decoration: none; color: red;">AdminGram</a></h1>

<div class="container">
    <h2>Utilisateurs</h2>

    <!-- Barre de recherche -->
    <form action="../../controllers/process.php" method="post">
        <label for="search">Recherche:</label>
        <input type="text" name="search" id="search" placeholder="Entrez un pseudo">
        <button type="submit" name="search_button_users">Rechercher</button>
    </form>

    <form action="../../controllers/process.php" method="post">
        <!-- Liste des utilisateurs -->
        <?php

        if (isset($_SESSION['users'])) {
            $users = $_SESSION['users'];
            foreach ($users as $user) {
                echo '<div class="user">';
                //echo '<img src="/profile_images/' . $user['Img'] . '" alt="' . $user['pseudo'] . '">';
                //echo '<span>' . $user['pseudo'] . '</span>';
                echo '<span>Email: ' . $user['Email'] . '</span>';
                echo '<span>Prénom: ' . $user['Prenom'] . '</span>';
                echo '<span>Nom: ' . $user['Nom'] . '</span>';
                echo '<span>Date de naissance: ' . $user['date_naissance'] . '</span>';

                echo '<div class="delete-button">';
                echo '<button type="submit" name="delete_user"><i class="gg-trash"></i></button>';
                echo '</div>';

                echo '<input type="hidden" name="user_id" value="' . $user['IDuser'] . '">';

                echo '</div>';
            }
        } else {
            echo '<p>Aucun utilisateur pour le moment.</p>';
        }
        ?>
    </form>
</div>

</body>
</html>
