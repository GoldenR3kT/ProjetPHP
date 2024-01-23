<?php

header('Location: ./app/views/auth/register.php');
session_start();

// Obtenez le chemin de l'URL après le nom de domaine
$request_uri = $_SERVER['REQUEST_URI'];

// Supprimez les éventuelles barres obliques en début et fin de chaîne
$request_uri = trim($request_uri, '/');

// Divisez l'URL en segments
$segments = explode('/', $request_uri);

// Déterminez le contrôleur en fonction du premier segment de l'URL
$controller_name = isset($segments[0]) && $segments[0] !== '' ? ucfirst($segments[0]) . 'Controller' : 'AuthController';

// Déterminez l'action en fonction du deuxième segment de l'URL
$action = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';

// Inclure le contrôleur correspondant
$controller_file = "app/controllers/{$controller_name}.php";

if (file_exists($controller_file)) {
    include_once $controller_file;

    // Instancier le contrôleur
    $controller = new $controller_name();

    // Appeler la méthode d'action
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Action non trouvée";
    }
} else {
    echo "Contrôleur non trouvé";
}


?>