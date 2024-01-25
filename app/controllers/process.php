<?php
session_start();

require_once 'AuthController.php';
require_once 'PostController.php';
require_once 'AdminController.php';
require_once '../models/User.php';
require_once '../models/Post.php';
$postController = new PostController();

// Gérer les actions en fonction des formulaires soumis
if (isset($_POST['registry'])) {
    $AuthController = new AuthController();
    $AuthController->register();
}

if (isset($_POST['connexion'])) {

    $AuthController = new AuthController();
    $user = $AuthController->login();
    $_SESSION['user'] = $user;
    // Si l'utilisateur est connecté, récupérer les posts et les stocker en session
    if ($user) {
        if ($user->Admin){
            $AdminController = new AdminController();
            $users = $AdminController->index();
            $_SESSION['users'] = $users;
            header('Location: ../views/admin/admin_home.php');
        }
        else{
            $posts = $postController->index();
            $_SESSION['posts'] = $posts;

            header('Location: ../views/social/home.php');
            exit;
        }

    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../views/auth/logout.php');
}

if (isset($_POST['friends'])) {
    header('Location: ../views/social/friends.php');
}

if (isset($_POST['new_post'])) {
    header('Location: ../views/social/create.php');
}

if (isset($_POST['poster'])) {
    $postController = new PostController();
    $postController->create();

    $posts = $postController->index();
    $_SESSION['posts'] = $posts;


    header('Location: ../views/social/home.php');
}


if (isset($_POST['like'])) {
    // Récupérez l'ID du post sur lequel l'utilisateur a cliqué "Like"
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    // Si vous avez l'ID, procédez à l'incrémentation dans la base de données
    if ($postId) {
        Post::incrementLikes($postId);
    }

    // Mettez à jour la variable de session ou récupérez à nouveau les posts de la base de données
    // ...

    $_SESSION['posts'] = Post::getPaginatedPosts(0, 10);

    // Ajoutez un message de débogage
    error_log("Session updated with latest posts: " . print_r($_SESSION['posts'], true));

    // Redirigez l'utilisateur vers la même page après le traitement du bouton "like"
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


