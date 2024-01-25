<?php
define('ROOT_PATH', dirname(__DIR__));
require_once("Controller.php");
require_once(ROOT_PATH . '/models/Post.php');
require_once(ROOT_PATH . '/models/User.php');
session_start();


class PostController extends Controller
{
    // Méthode pour afficher la liste des publications

    public static function index($currentPage)
    {
        // Exemple basique de récupération des publications depuis la base de données
        $postsPerPage = 10; // Nombre de publications par page
        print_r($currentPage);
        $offset = ($currentPage - 1) * $postsPerPage;
        // Exemple basique d'utilisation d'un modèle pour récupérer les publications
        $posts = Post::getPaginatedPosts($offset, $postsPerPage);

        // Exemple basique de calcul du nombre total de pages
        $totalPosts = Post::getTotalPosts();
        $totalPages = ceil($totalPosts / $postsPerPage);

        return $posts;
    }

    public static function getNbPages()
    {
        $totalPosts = Post::getNbTotalPosts();
        $postsPerPage = 10;

        return ceil($totalPosts / $postsPerPage);
    }

    public function create()
    {
        $error = null;
        // Validation des données
        $content = htmlspecialchars($_POST['content']);
        $title = htmlspecialchars($_POST['title']);
        $visibility = ($_POST['visibility'] === 'public') ? 'public' : 'friends';

        if (isset($_SESSION['user_id'])) {
            $id_user = $_SESSION['user_id'];
            $author = User::getFirstNameById($id_user);
        } else {
            $id_user = null;
            $author = null;
        }

        // Création d'un tableau de données pour la publication
        $postData = [
            'IDuser' => $id_user,
            'IDpost' => null,
            'Message' => $content,
            'Img' => null,  // Initialisez Img à null pour l'instant
            'titre' => $title,
            'visibilite' => $visibility,
            'aime' => 0,  // Initialisez le nombre de likes à zéro
            'author'=>$author,
            'aimePas' => 0
        ];

        // Traitement du téléchargement de la photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['photo'];
            $filename = uniqid() . '_' . basename($uploadedFile['name']);
            $uploadPath = '../../uploads/' . $filename;

            if (move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
                $postData['Img'] = $filename;
            } else {
                // Gestion de l'erreur de téléchargement
                $error = "Erreur lors du téléchargement de la photo.";
            }
        }

        // Création de l'objet Post
        $post = new Post($postData);
        print_r($post);

        // Enregistrement de la publication dans la base de données
        if (!$error) {
            $post->save();

            // Mise à jour de la liste des publications en session
            $_SESSION['posts'] = Post::getPaginatedPosts(0, 10);

            return;
        } else {
            // Gestion de l'erreur (téléchargement de la photo ou enregistrement en base de données)
            $error = "Erreur lors de la création de la publication.";
        }

        // Affichage de l'erreur dans la vue
        include('../views/social/error_view.php');
        exit;
    }



    // Méthode pour afficher une publication spécifique
    public function getPost($id) {
        // Exemple basique de récupération d'une publication par son ID depuis la base de données
        return Post::getPostById($id);
    }

    public static function searchPosts($searchTerm)
    {
        $db = include('../Database.php');

        // Utilisez une requête SQL avec des conditions pour le titre et l'auteur
        $stmt = $db->prepare("SELECT * FROM post WHERE titre LIKE :term OR author LIKE :term");
        $stmt->execute(['term' => "%$searchTerm%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Autres méthodes nécessaires...

    // Dans votre PostController.php

// Ajoutez cette méthode pour récupérer les commentaires d'un post
    public function getComments($postId) {
        $comments = Comment::getCommentsByPostId($postId);
        return $comments;
    }


}
