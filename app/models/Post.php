<?php


class Post
{


    // Propriétés du modèle
    public $IDpost;
    public $IDuser; // Assurez-vous de stocker les mots de passe de manière sécurisée (par exemple, hachage et salage)
    public $content;
    public $photo;
    public $title;
    public $visibility;


    public function __construct($data)
    {
        $this->IDpost = $data['IDpost'];
        $this->IDuser = $data['IDuser'];
        $this->content = $data['Message'];
        $this->photo = $data['Img'];
        $this->title = $data['titre'];
        $this->visibility = $data['visibilite'];
    }


    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO USERS (Message, Img, titre, visibilite) VALUES ( ?,?, ?, ?)");
        $stmt->execute([$this->content, $this->photo, $this->title, $this->visibility]);

    }

    public static function getTotalPosts()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT COUNT(*) FROM POST");
        $stmt->execute([]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public static function getPaginatedPosts($offset, $limit)
    {
        // Logique pour récupérer les publications depuis la base de données
        // Utilisez une requête SQL pour obtenir les publications paginées
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM posts LIMIT ?, ?");
        $stmt->execute([$offset, $limit]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

}


?>
