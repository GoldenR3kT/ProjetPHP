<!-- app/views/posts/create.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un post</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="container">
    <h2>Créer un post</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="/posts/create" method="post" enctype="multipart/form-data">
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
                <option value="private">Privé</option>
                <option value="friends">Amis</option>
                <option value="public">Publique</option>
            </select>
        </p>

        <button type="submit">Créer un post</button>
    </form>

    <p><a href="/posts">Revenir a l'accueil</a></p>
</div>

</body>
</html>
