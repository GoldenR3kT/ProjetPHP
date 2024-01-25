<!-- admin_view.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../logout_icon.css">
</head>
<body>
<div class="logout-button button">
    <form action="../../controllers/process.php" method="post">
        <button type="submit" name="logout"><i class="gg-log-out"></i></button>
    </form>
</div>
<h1>Admin Panel</h1>

<div class="container">
    <h2>Users</h2>

    <!-- Barre de recherche -->
    <form action="#" method="post">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" placeholder="Enter username">
        <button type="submit" name="search_button">Search</button>
    </form>

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
                echo '<span>Date d\'inscription: ' . $user['date_naissance'] . '</span>';
                echo '<button>Supprimer</button>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucun utilisateur pour le moment.</p>';
        }
        ?>
</div>

</body>
</html>
