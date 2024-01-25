<?php

require_once("Controller.php");
class AdminController extends Controller
{
    public static function index()
    {
        $db = include('../Database.php');
        $stmt = $db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function searchUsers($searchTerm)
    {
        $db = include('../Database.php');

        // Utilisez une requête SQL avec des conditions pour le prénom, le nom et l'email
        $stmt = $db->prepare("SELECT * FROM users WHERE Prenom LIKE :term OR Nom LIKE :term OR Email LIKE :term");
        $stmt->execute(['term' => "%$searchTerm%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser($userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("DELETE FROM users WHERE IDuser = ?");
        return $stmt->execute([$userId]);
    }

    public static function deletePost($postId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("DELETE FROM post WHERE IDpost = ?");
        return $stmt->execute([$postId]);
    }
}
