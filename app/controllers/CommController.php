<?php
require_once(ROOT_PATH . '/models/Comment.php');
session_start();

class CommController
{
    public static function addComment($postID, $userID, $commentText)
    {
        // Création d'une instance de la classe Comment avec les données fournies
        $commentData = [
            'IDpost' => $postID,
            'IDuser' => $userID,
            'commentaire' => $commentText,
        ];

        $comment = new Comment($commentData);

        // Appel de la méthode save pour enregistrer le commentaire dans la base de données
        $comment->save();
    }

    // Vous pouvez ajouter d'autres méthodes pour d'autres actions liées aux commentaires


    public function getCommentsForPost($postID)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT commentaire.*, users.pseudo AS auteur FROM commentaire INNER JOIN users ON commentaire.IDuser = users.IDuser WHERE IDpost = ?");
        $stmt->execute([$postID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}




