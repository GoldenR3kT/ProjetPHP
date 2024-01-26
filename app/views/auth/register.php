<!-- app/views/auth/register.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
<h1><a href="login.php" id="home" style="text-decoration: none; color: black;">MyGram</a></h1>
<div class="container">
    <h2>Inscription</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post" action="../../controllers/process.php">
    <p>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" required>
        </p>

        <p>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
        </p>

        <p>
            <label for="confirm_password">Confirmer mot de passe:</label>
            <input type="password" name="confirm_password" required>
        </p>

        <p>
            <label for="first_name">Prénom:</label>
            <input type="text" name="first_name" required>
        </p>

        <p>
            <label for="last_name">Nom:</label>
            <input type="text" name="last_name" required>
        </p>

        <p>
            <label for="birthdate">Date de naissance:</label>
            <input type="date" name="birthdate" required>
        </p>

        <p>
            <label for="phone">Numéro de téléphone:</label>
            <input type="tel" name="phone" required>
        </p>

        <button name="registry" type="submit">Inscription</button>
    </form>

    <p>Vous avez déja un compte? <a href="./login.php">Connectez vous ici</a></p>
</div>

</body>
</html>
