<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Rediriger l'utilisateur s'il n'est pas connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../style.css">
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

<title>Friends</title>
</head>
<div class="container">
    <h2>Liste d'ami</h2>
    <?php
    if (isset($_SESSION['friends']) && !empty($_SESSION['friends'])): ?>
        <ul>
            <?php foreach ($_SESSION['friends'] as $friend): ?>
                <li>
                    <?php echo $friend['Nom'] . ' ' . $friend['Prenom'] . ' ' . ' Pseudo:' . $friend['pseudo']; ?>
                    <form action="../../controllers/process.php" method="post">
                        <input type="hidden" name="friend_id_to_remove" value="<?php echo $friend['IDuser']; ?>">
                        <button type="submit" name="remove_friend">Retirer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Ajoutez des ami!</p>
    <?php endif; ?>

    <h2>Ajouter un ami</h2>
    <!-- Form to add friends -->
    <form action="../../controllers/process.php" method="post">
        <label for="search">Recherche:</label>
        <input type="text" id="search" name="search" placeholder="Entrez un pseudo">
        <button type="submit" name="search_friends">Rechercher</button>
    </form>

    <?php if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])): ?>
        <!-- Display search results -->
        <h3>Search Results</h3>
        <ul>
            <?php foreach ($_SESSION['search_results'] as $result): ?>
                <li>

                    <?php echo $result['Prenom'];
                    echo "  ";
                    echo $result['Nom']; ?>
                    <form action="../../controllers/process.php" method="post">
                        <input type="hidden" name="friend_id" value="<?php echo $result['IDuser']; ?>">
                        <button type="submit" name="add_friend">Add Friend</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>
</body>
</html>
