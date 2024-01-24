<?php
    define('ROOT_PATH', dirname(__DIR__));

    require_once("Controller.php");
    require_once(ROOT_PATH . '/models/Post.php');
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
    public function create()
    {
        // Votre logique de création de publication ici
        // Assurez-vous de valider les données entrées par l'utilisateur

        $post = new Post();
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];
        $post->visibility = $_POST['visibility'];

        // Exemple basique de traitement du téléchargement de la photo
        if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['photo'];
            $filename = uniqid() . '_' . $uploadedFile['name'];
            move_uploaded_file($uploadedFile['tmp_name'], 'uploads/' . $filename);
            $post->photo = $filename;
        }

        $post->save(); // Enregistrement de la publication dans la base de données

        // Rediriger vers la liste des publications après la création
        header('Location: /posts');
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
