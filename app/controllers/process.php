<?php
session_start();

require_once 'AuthController.php';
require_once 'PostController.php';

// Gérer les actions en fonction des formulaires soumis
if (isset($_POST['registry'])) {
    $AuthController = new AuthController();
    $AuthController->register();
}

if (isset($_POST['connexion'])) {

    $AuthController = new AuthController();
    $user = $AuthController->login();
    // Si l'utilisateur est connecté, récupérer les posts et les stocker en session
    if ($user) {
        $postController = new PostController();
        $posts = $postController->index();
        print_r($posts);
        $_SESSION['posts'] = $posts;

        header('Location: ../views/social/home.php'); // Remplacez index.php par le nom de votre vue
        exit;
    }
}


?>
