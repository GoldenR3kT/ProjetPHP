<?php

require_once '../models/Friendship.php';

class FriendshipController
{
    public static function index()
    {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $friends = Friendship::getFriends($userId);
        return $friends;
    }

    // Méthode pour ajouter un ami
// Dans le contrôleur FriendshipController, méthode addFriend

    public function addFriend($userID1, $userID2)
    {
        // Vérifier si l'utilisateur essaye de s'ajouter lui-même comme ami
        if ($userID1 == $userID2) {
            // Afficher un message d'erreur ou rediriger avec un message d'erreur
            // Exemple : header('Location: ../views/error.php?message=You cannot add yourself as a friend.');
            return false;
        }

        // Vérifier si l'ami existe déjà dans la liste
        $friends = Friendship::getFriends($userID1);
        foreach ($friends as $friend) {
            if ($friend['IDuser'] == $userID2) {
                // Afficher un message d'erreur ou rediriger avec un message d'erreur
                // Exemple : header('Location: ../views/error.php?message=This user is already your friend.');
                return false;
            }
        }

        // Ajouter l'ami seulement si les vérifications passent
        return Friendship::addFriendship($userID1, $userID2);
    }


    // Méthode pour supprimer un ami
    public function removeFriend($userID1, $userID2)
    {
        // Appel à la méthode du modèle pour supprimer une relation d'amitié
        return Friendship::removeFriendship($userID1, $userID2);
    }

    // Méthode pour récupérer la liste des amis d'un utilisateur
    public function getFriends($userID)
    {
        // Appel à la méthode du modèle pour récupérer la liste des amis
        return Friendship::getFriends($userID);
    }

    public function searchUsers($searchTerm)
    {
        // Assurez-vous de nettoyer et de préparer la recherche pour éviter les attaques par injection SQL
        $cleanSearchTerm = '%' . $searchTerm . '%'; // Ajoutez des wildcards pour rechercher partiellement

        // Utilisez une méthode du modèle User pour rechercher les utilisateurs
        $users = User::searchUsersByName($cleanSearchTerm);

        // Retourne les résultats de la recherche
        return $users;
    }
}


