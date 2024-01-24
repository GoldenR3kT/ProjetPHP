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

?>
