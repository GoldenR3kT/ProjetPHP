<?php
// Inclure la classe UserManager
require_once 'AuthController.php';

// Inclure la classe PostController
require_once 'PostController.php';

// Vérifier si le formulaire a été soumis
if (isset($_POST['registry'])) {
    // Créer une instance de UserManager
    $AuthController = new AuthController();

    // Appeler la fonction register de UserManager
    $AuthController->register();
}

if (isset($_POST['connexion'])) {
    // Créer une instance de UserManager
    $AuthController = new AuthController();

    // Appeler la fonction register de UserManager
    $AuthController->login();
}


// Créer une instance de PostController
$postController = new PostController();

// Appeler la méthode index de PostController pour récupérer les données nécessaires
$result = $postController->index();

// Extraire les données de la résultat
$posts = $result['posts'];
$totalPages = $result['totalPages'];

// Inclure la vue home.php
include 'home.php';
?>
