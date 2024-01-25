<?php
session_start();

require_once 'AuthController.php';
require_once 'PostController.php';
require_once 'AdminController.php';
require_once 'FriendshipController.php';
require_once 'CommController.php';
require_once '../models/User.php';
require_once '../models/Post.php';
require_once '../models/Friendship.php';


$postController = new PostController();
$adminController = new AdminController();
$AuthController = new AuthController();
$friendshipController = new FriendshipController();
$commentaireController = new CommController();
// Gérer les actions en fonction des formulaires soumis
if (isset($_POST['registry'])) {
    $AuthController->register();
}

if (isset($_POST['connexion'])) {

    $user = $AuthController->login();
    $_SESSION['user'] = $user;
    // Si l'utilisateur est connecté, récupérer les posts et les stocker en session
    if ($user) {
        $_SESSION['currentPage'] = 1;
        if ($user->Admin) {
            $users = $adminController->index();
            $_SESSION['users'] = $users;

            $posts = $postController->index(1);
            $_SESSION['posts'] = $posts;
            $_SESSION['totalPages'] = $postController::getNbPages();

            header('Location: ../views/admin/admin_home.php');
        } else {
            $posts = $postController->index(1);
            $_SESSION['posts'] = $posts;

            $_SESSION['totalPages'] = $postController::getNbPages();

            header('Location: ../views/social/home.php');
            exit;
        }

    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../views/auth/logout.php');
}

// Gérer les actions en fonction des formulaires soumis
if (isset($_POST['friends'])) {
    $_SESSION['friends'] = $friendshipController->index();
    header('Location: ../views/social/friends.php');
    exit;
}


if (isset($_POST['new_post'])) {
    header('Location: ../views/social/create.php');
}

if (isset($_POST['poster'])) {
    $postController->create();

    $posts = $postController->index(1);
    $_SESSION['posts'] = $posts;


    header('Location: ../views/social/home.php');
}


// Dans votre fichier process.php
if (isset($_POST['like'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Vérifier si l'utilisateur a déjà aimé le post
    $hasLiked = Post::hasLiked($postId, $userId);

    if ($hasLiked) {
        // Si l'utilisateur a déjà aimé, supprimer le like
        Post::removeLike($postId, $userId);
    } else {
        // Sinon, ajouter le like
        Post::addLike($postId, $userId);
    }

    // Mettre à jour la variable de session ou récupérer à nouveau les posts de la base de données
    $_SESSION['posts'] = Post::getPaginatedPosts(1, 10);

    // Rediriger l'utilisateur vers la même page après le traitement du bouton "like"
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Dans votre fichier process.php
if (isset($_POST['dislike'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Vérifier si l'utilisateur a déjà disliké le post
    $hasDisliked = Post::hasDisliked($postId, $userId);

    if ($hasDisliked) {
        // Si l'utilisateur a déjà disliké, supprimer le dislike
        Post::removeDislike($postId, $userId);
    } else {
        // Sinon, ajouter le dislike
        Post::addDislike($postId, $userId);

    }

    // Mettre à jour la variable de session ou récupérer à nouveau les posts de la base de données
    $_SESSION['posts'] = Post::getPaginatedPosts(1, 10);

    // Rediriger l'utilisateur vers la même page après le traitement du bouton "dislike"
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if (isset($_POST['delete_user'])) {

    $idUserToDelete = $_POST['user_id'];

    $adminController::deleteUser($idUserToDelete);

    $users = $adminController->index();
    $_SESSION['users'] = $users;

    header('Location: ../views/admin/admin_manage_users.php');
}

if (isset($_POST['delete_post'])) {

    $idPostToDelete = $_POST['postId'];

    $adminController::deletePost($idPostToDelete);

    $_SESSION['posts'] = Post::getPaginatedPosts(0, 10);

    header('Location: ../views/admin/admin_home.php');
}


if (isset($_POST['pagination'])) {
    $selectedPage = $_POST['pagination'];

    $posts = $postController->index($selectedPage);

    $_SESSION['currentPage'] = $selectedPage;

    $_SESSION['posts'] = $posts;


    header('Location: ../views/social/home.php?page=' . $selectedPage);

    exit;
}

if (isset($_POST['pagination_admin'])) {
    $selectedPage = $_POST['pagination_admin'];

    $posts = $postController->index($selectedPage);

    $_SESSION['currentPage'] = $selectedPage;

    $_SESSION['posts'] = $posts;

    header('Location: ../views/admin/admin_home.php?page=' . $selectedPage);
}

// Dans ton fichier process.php

if (isset($_POST['add_friend'])) {
    // Assure-toi que l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id'];
        $newFriendID = $_POST['friend_id'];

        // Appelle la méthode du contrôleur pour ajouter un nouvel ami

        $friendshipController->addFriend($userID, $newFriendID);


        $_SESSION['friends'] = $friendshipController->index();
        header('Location: ../views/social/friends.php');
        exit;
    } else {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header('Location: ../views/auth/login.php');
        exit;
    }
}

if (isset($_POST['remove_friend'])) {
    // Assure-toi que l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id'];
        $friendIDToRemove = $_POST['friend_id_to_remove'];

        print_r($userID);
        print_r($friendIDToRemove);
        // Appelle la méthode du contrôleur pour supprimer un ami

        $friendshipController->removeFriend($userID, $friendIDToRemove);

        $_SESSION['friends'] = $friendshipController->index();
        header('Location: ../views/social/friends.php');
        exit;
    } else {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header('Location: ../views/auth/login.php');
        exit;
    }
}

if (isset($_POST['search_friends'])) {
    // Get the search term from the form
    $searchTerm = $_POST['search'];

    // Perform the search for users
    $searchResults = $friendshipController->searchUsers($searchTerm);

    // Store the search results in the session to be used in the view
    $_SESSION['search_results'] = $searchResults;

    // Redirect back to the friends page to display search results
    header('Location: ../views/social/friends.php');
    exit();
}


if (isset($_POST['search_button_users'])) {
    $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';


    // Effectuer la recherche
    $users = $adminController->searchUsers($searchTerm);

    // Mettre les résultats de la recherche en session
    $_SESSION['users'] = $users;

    // Rediriger vers la page d'administration avec les résultats de la recherche
    header('Location: ../views/admin/admin_manage_users.php');
    exit;
}

if (isset($_POST['search_button_posts'])) {
    $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

    // Effectuer la recherche
    $posts = $postController->searchPosts($searchTerm);

    // Mettre les résultats de la recherche en session
    $_SESSION['posts'] = $posts;

    // Rediriger vers la page des posts avec les résultats de la recherche
    header('Location: ../views/social/home.php');

}

if (isset($_POST['search_button_posts_admin'])) {
    $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

    // Effectuer la recherche
    $posts = $postController->searchPosts($searchTerm);

    // Mettre les résultats de la recherche en session
    $_SESSION['posts'] = $posts;
    $_SESSION['totalPages'] = $postController::getNbPages();

    // Rediriger vers la page des posts avec les résultats de la recherche
    header('Location: ../views/admin/admin_home.php');


}

if (isset($_POST['manage_users'])) {
    $users = $adminController->index();
    $_SESSION['users'] = $users;
    header('Location: ../views/admin/admin_manage_users.php');
}

if (isset($_POST['profile'])) {


    header('Location: ../views/social/profile.php');
}

if (isset($_POST['comment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);
    header('Location: ../views/social/post.php');
}

if (isset($_POST['addComment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $commentContent = isset($_POST['commentContent']) ? $_POST['commentContent'] : '';

    // Ajoutez la logique pour créer et enregistrer le commentaire
    Comment::addComment($postId, $_SESSION['user_id'], $commentContent);

    // Rediriger l'utilisateur vers la page des commentaires après l'ajout du commentaire
    header('Location: ../views/social/post.php?id=' . $postId);
    exit;
}


