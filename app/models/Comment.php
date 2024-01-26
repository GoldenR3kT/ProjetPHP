<?php

class Comment
{
    // Propriétés du modèle
    public $IDcommentaire;
    public $IDpost;
    public $IDuser;
    public $commentaire;


    public function __construct($data)
    {
        // Assurez-vous que les clés existent avant de les utiliser
        $this->IDcommentaire = isset($data['IDcommentaire']) ? $data['IDcommentaire'] : null;
        $this->IDpost = isset($data['IDpost']) ? $data['IDpost'] : null;
        $this->IDuser = isset($data['IDuser']) ? $data['IDuser'] : null;
        $this->commentaire = isset($data['commentaire']) ? $data['commentaire'] : null;
        $this->auteur = isset($data['auteur']) ? $data['auteur'] : null; // Nouvelle propriété pour le nom de l'auteur

    }

    // Méthode pour enregistrer un nouveau commentaire
    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO commentaire (IDpost, IDuser, commentaire) VALUES (?, ?, ?)");
        $stmt->execute([$this->IDpost, $this->IDuser, $this->commentaire]);
    }

    // Ajouter une méthode pour compter les commentaires pour une publication donnée
    public static function countCommentsForPost($postId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT COUNT(*) AS commentCount FROM commentaire WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['commentCount'];
    }

}

