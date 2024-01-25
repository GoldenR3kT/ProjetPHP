<!-- app/views/friends.php -->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amis</title>
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
<h1><a href="home.php" id="home" style="text-decoration: none; color: black;">MyGram</a></h1>
<div class="container">
    <h2>Liste d'amis</h2>

    <?php
    // Simuler une liste d'amis (à remplacer par vos données réelles)
    $users = array(
        array('name' => 'Ami 1', 'photo' => 'profile1.jpg'),
        array('name' => 'Ami 2', 'photo' => 'profile2.jpg'),
        array('name' => 'Ami 3', 'photo' => 'profile3.jpg'),
        array('name' => 'Ami 4', 'photo' => 'profile4.jpg'),
        array('name' => 'Ami 5', 'photo' => 'profile5.jpg')
    );

    if (!empty($users)) {
        foreach ($users as $user) {
            echo '<div class="user">';
            echo '<img src="/profile_images/' . $user['photo'] . '" alt="' . $user['name'] . '">';
            echo '<span>' . $user['name'] . '</span>';
            echo '<div class="delete-button">';
            echo '<button type="submit" name="delete_friend"><i class="gg-trash"></i></button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucun ami pour le moment.</p>';
    }
    ?>

    <p><a href="./home.php">Retour à l'accueil</a></p>
</div>
</body>
</html>
