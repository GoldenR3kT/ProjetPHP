<?php
define('ROOT_PATH', dirname(__DIR__));
require_once("Controller.php");
require_once(ROOT_PATH . '/models/Post.php');
require_once(ROOT_PATH . '/models/User.php');
session_start();


class PostController extends Controller
{
    // Méthode pour afficher la liste des publications

    public static function index()
    {
        // Exemple basique de récupération des publications depuis la base de données
        $postsPerPage = 10; // Nombre de publications par page
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $postsPerPage;

        // Exemple basique d'utilisation d'un modèle pour récupérer les publications
        $posts = Post::getPaginatedPosts($offset, $postsPerPage);
        //print_r($posts);
        // Exemple basique de calcul du nombre total de pages
        $totalPosts = Post::getTotalPosts();
        $totalPages = ceil($totalPosts / $postsPerPage);

        return $posts;
    }

    // Méthode pour afficher le formulaire de création de publication
    public function createForm()
    {
        return $this->view('posts.create');
    }

    // Méthode pour traiter la soumission du formulaire de création de publication
// ...

    public function create()
    {
        $error = null;
        // Validation des données
        $content = htmlspecialchars($_POST['content']);
        $title = htmlspecialchars($_POST['title']);
        $visibility = ($_POST['visibility'] === 'public') ? 'public' : 'friends';

        if (isset($_SESSION['user_id'])) {
            $id_user = $_SESSION['user_id'];
        } else {
            $id_user = null;
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

        // Enregistrement de la publication dans la base de données
        if (!$error) {
            $post->save();
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
    public function show($id)
    {
        // Exemple basique de récupération d'une publication par son ID depuis la base de données
        $post = Post::getById($id);

        if (!$post) {
            // Gérer le cas où la publication n'est pas trouvée (redirection, affichage d'une erreur, etc.)
            header('Location: /posts');
            exit;
        }

        return $this->view('posts.show', ['post' => $post]);
    }

    // Autres méthodes nécessaires...

}
