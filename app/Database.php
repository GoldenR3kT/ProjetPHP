<?php

$servername = "linserv-info-01.campus.unice.fr"; // Adresse du serveur MySQL (peut être localhost)
$username = "si112114"; // Nom d'utilisateur MySQL (par défaut, root pour XAMPP)
$password = "si112114"; // Mot de passe MySQL (celui que vous avez défini)
$dbname = "si112114_ProjetPHP"; // Nom de votre base de données

$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";


try {
    global $db;
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

?>