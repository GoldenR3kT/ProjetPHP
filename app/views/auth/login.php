<!-- app/views/auth/login.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
<h1><a href="login.php" id="home" style="text-decoration: none; color: black;">MyGram</a></h1>

<div class="container">
    <h2>Connexion</h2>

    <?php
    if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post" action="../../controllers/process.php">
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
        </p>

        <button name= "connexion" type="submit">Connexion</button>
    </form>

    <p>Vous n'avez pas de compte? <a href="./register.php">Inscrivez vous ici</a></p>
</div>

</body>
</html>
