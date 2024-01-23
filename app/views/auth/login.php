<!-- app/views/auth/login.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="container">
    <h2>Connection</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
        </p>

        <p>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
        </p>

        <button type="submit">Connection</button>
    </form>

    <p>Vous n'avez pas de compte? <a href="./register.php">Inscrivez vous ici</a></p>
</div>

</body>
</html>
