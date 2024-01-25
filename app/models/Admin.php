<?php

require_once '../Database.php';

class Admin
{
    public static function getAllUsers()
    {
        $db = include('../Database.php');
        $stmt = $db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser($userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public static function deletePost($postId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$postId]);
    }
}
