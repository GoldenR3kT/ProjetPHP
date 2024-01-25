<?php

class Post
{


    // Propriétés du modèle
    public $IDpost;
    public $IDuser;

    public $content;
    public $photo;
    public $title;
    public $visibility;

    public $like;

    public $author;


    public function __construct($data)
    {
        $this->IDuser = $data['IDuser'];
        $this->IDpost = $data['IDpost'];
        $this->content = $data['Message'];
        $this->photo = $data['Img'];
        $this->title = $data['titre'];
        $this->visibility = $data['visibilite'];
        $this->like= $data['aime'];
        $this->author=$data['author'];
    }


    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO POST (IDuser,Message, Img, titre, visibilite,aime,author) VALUES (?,?, ?, ?, ?, ?,?)");
        $stmt->execute([$this->IDuser,$this->content, $this->photo, $this->title, $this->visibility, $this->like,$this->author]);

    }

    public static function getName($IDuser)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT DISTINCT users.Nom FROM post JOIN users ON post.IDuser = users.IDuser WHERE post.IDuser = ?");
        $stmt->execute([$IDuser]);
        return $stmt->fetchColumn();
    }


    public static function getTotalPosts()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM POST");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }


    public static function getPaginatedPosts($offset, $limit)
    {
        // Logique pour récupérer les publications depuis la base de données
        // Utilisez une requête SQL pour obtenir les publications paginées
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM post LIMIT ?, ?");
        $stmt->bindParam(1, $offset, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Dans votre classe Post
    public static function incrementLikes($postId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("UPDATE post SET aime = aime + 1 WHERE IDpost = ?");
        $stmt->execute([$postId]);

        // Ajoutez un message de débogage
        error_log("Likes incremented for post with ID: " . $postId);
    }



}

?>