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

    // Validation du numéro de téléphone
    $phone = $_POST['phone'];

    // Utilisez une expression régulière pour vérifier le format du numéro de téléphone
    if (!preg_match('/^0[0-9]{9}$/', $phone)) {
        // Ajoutez un message d'erreur à la session
        $_SESSION['error'] = "Veuillez entrez un numéro de téléphone valide.";

        // Redirigez l'utilisateur vers la page d'inscription avec le message d'erreur
        header('Location: ../views/auth/register.php');
        exit;
    }

    // Validation de l'âge minimum (13 ans)
    $birthdate = $_POST['birthdate'];
    $minAge = 13;

    // Convertir la date de naissance en objet DateTime
    $dob = new DateTime($birthdate);

    // Obtenir la date actuelle
    $currentDate = new DateTime();

    // Calculer la différence d'âge
    $age = $currentDate->diff($dob)->y;

    // Vérifier si l'âge est inférieur à l'âge minimum requis
    if ($age < $minAge) {
        // Ajoutez un message d'erreur à la session
        $_SESSION['error'] = "Vous devez avoir au moins $minAge ans pour vous inscrire.";

        // Redirigez l'utilisateur vers la page d'inscription avec le message d'erreur
        header('Location: ../views/auth/register.php');
        exit;
    }

    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifiez si les deux mots de passe sont identiques
    if ($password !== $confirmPassword) {
        // Ajoutez un message d'erreur à la session
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";

        // Redirigez l'utilisateur vers la page d'inscription avec le message d'erreur
        header('Location: ../views/auth/register.php');
        exit;
    } else {
        $AuthController->register();
        header('Location: ../views/auth/login.php');
    }

    // Continuez avec le reste du processus d'inscription si les mots de passe sont identiques
    // ...
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
    if (!$user) {
        // Ajoutez une variable d'erreur à la session
        $_SESSION['error'] = "Email ou mot de passe incorrect.";

        // Redirigez l'utilisateur vers la page de connexion
        header('Location: ../views/auth/login.php');
        exit;
    }

}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../views/auth/logout.php');
}

// Gérer les actions en fonction des formulaires soumis
if (isset($_POST['friends'])) {
    $_SESSION['friends'] = $friendshipController->index();

    if (isset($_SESSION['user_id'])) {
        $_SESSION['search_results'] = null;
        $userId = $_SESSION['user_id'];
        $user = User::getById($userId);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_friends.php');
            } else {
                header('Location: ../views/social/friends.php');
            }
        }
    }

    exit;
}


if (isset($_POST['new_post'])) {
    header('Location: ../views/social/create.php');
}

if (isset($_POST['poster'])) {
    $postController->create();

    $posts = $postController->index(1);
    $_SESSION['posts'] = $posts;
    $_SESSION['totalPages'] = $postController::getNbPages();

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $user = User::getById($userId);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_home.php');
            } else {
                header('Location: ../views/social/home.php');
            }
        }
    }
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
    $posts = $postController->index(1);
    $_SESSION['posts'] = $posts;

    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);

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

    $posts = $postController->index(1);
    $_SESSION['posts'] = $posts;

    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);

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

    $posts = $postController->index(1);
    $_SESSION['posts'] = $posts;
    $_SESSION['totalPages'] = $postController::getNbPages();

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

        $user = User::getById($userID);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_friends.php');
            } else {
                header('Location: ../views/social/friends.php');
            }
        }
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

        // Appelle la méthode du contrôleur pour supprimer un ami

        $friendshipController->removeFriend($userID, $friendIDToRemove);

        $_SESSION['friends'] = $friendshipController->index();
        $user = User::getById($userID);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_friends.php');
            } else {
                header('Location: ../views/social/friends.php');
            }
        }
        exit;
    } else {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header('Location: ../views/auth/login.php');
        exit;
    }
}

if (isset($_POST['search_friends'])) {

    if (isset($_SESSION['user_id'])) {
        // Get the search term from the form
        $userID = $_SESSION['user_id'];
        $searchTerm = $_POST['search'];

        // Perform the search for users
        $searchResults = $friendshipController->searchUsers($searchTerm);

        // Store the search results in the session to be used in the view
        $_SESSION['search_results'] = $searchResults;

        // Redirect back to the friends page to display search results
        $user = User::getById($userID);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_friends.php');
            } else {
                header('Location: ../views/social/friends.php');
            }
        }
    }

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


if (isset($_POST['comment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);

    header('Location: ../views/social/post.php');
}
if (isset($_POST['admin_comment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);

    header('Location: ../views/admin/admin_post.php');
}

if (isset($_POST['addComment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $commentContent = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

    // Ajoutez la logique pour créer et enregistrer le commentaire
    $commentaireController->addComment($postId, $_SESSION['user_id'], $commentContent);


    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);
    // Rediriger l'utilisateur vers la page des commentaires après l'ajout du commentaire
    header('Location: ../views/social/post.php?id=' . $postId);
    exit;
}

if (isset($_POST['admin_addComment'])) {
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;
    $commentContent = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

    // Ajoutez la logique pour créer et enregistrer le commentaire
    $commentaireController->addComment($postId, $_SESSION['user_id'], $commentContent);


    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $_SESSION['post'] = $postController->getPost($postId);
    $_SESSION['comments'] = $commentaireController->getCommentsForPost($postId);
    // Rediriger l'utilisateur vers la page des commentaires après l'ajout du commentaire
    header('Location: ../views/admin/admin_post.php?id=' . $postId);
    exit;
}

if (isset($_POST['profile'])) {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $user = User::getById($userId);
        if ($user) {
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_profile.php');
            } else {
                header('Location: ../views/social/profile.php');
            }
        }

    }

}

if (isset($_POST['update_profile'])) {
    // Assurez-vous que l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        // Récupérez les données du formulaire
        $userId = $_SESSION['user_id']; // Identifiant de l'utilisateur à mettre à jour
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $newPassword = $_POST['password']; // Nouveau mot de passe
        $confirmPassword = $_POST['confirm_password'];
        $profileImage = null; // Initialise la variable pour le nom de la nouvelle image de profil

        // Vérifiez si le mot de passe et la confirmation correspondent
        if ($newPassword !== $confirmPassword) {
            $_SESSION['update_profile_error'] = "Les mots de passe ne correspondent pas.";
            header('Location: ../views/social/profile.php');
            exit; // Arrêter l'exécution du script
        }

        // Traitement du téléchargement de la nouvelle photo de profil
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['profile_image'];
            $filename = uniqid() . '_' . basename($uploadedFile['name']);
            $uploadPath = '../../uploads/' . $filename;

            if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                $profileImage = $filename;
            } else {
                // Gestion de l'erreur de téléchargement
                exit("Erreur lors du téléchargement de la photo de profil.");
            }
        }

        // Récupérer l'utilisateur à partir de son ID
        $user = User::getById($userId);

        // Mettre à jour les informations du profil si l'utilisateur existe
        if ($user) {
            // Mettre à jour le profil de l'utilisateur
            $user->updateProfile($user, $userId, $pseudo, $email, $newPassword, $profileImage);

            $_SESSION['user'] = $user;
            $_SESSION['pseudo'] = $user->pseudo;
            $_SESSION['email'] = $user->email;
            $_SESSION['img'] = $user->img;
            // Rediriger l'utilisateur vers la page de profil ou une autre page appropriée
            if ($user->Admin) {
                header('Location: ../views/admin/admin_profile.php');
            } else {
                header('Location: ../views/social/profile.php');
            }

            exit();
        } else {
            // Gérer l'erreur si l'utilisateur n'existe pas
            exit("L'utilisateur n'existe pas.");
        }
    } else {
        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
        header('Location: ../views/auth/login.php');
        exit;
    }
}

