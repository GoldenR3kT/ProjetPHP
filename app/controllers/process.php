<?php
session_start();

require_once 'AuthController.php';
require_once 'PostController.php';
require_once 'AdminController.php';

$postController = new PostController();

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
    exit;
}
