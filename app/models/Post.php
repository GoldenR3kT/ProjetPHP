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
    public $dislike;

    public $date_post;


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
        $this->dislike= $data['aimePas'];
        $this->date_post=$data['date_post'];
    }


    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO POST (IDuser, Message, Img, titre, visibilite, aime, author, aimePas, date_post) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Obtenez la date actuelle au format YYYY-MM-DD
        $currentDate = date('Y-m-d');

        // Exécutez la requête en liant les valeurs et la date actuelle
        $stmt->execute([$this->IDuser, $this->content, $this->photo, $this->title, $this->visibility, $this->like, $this->author, $this->dislike, $currentDate]);
    }


    public static function getTotalPosts()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM POST");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public static function getNbTotalPosts()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM post");
        $stmt->execute();
        return $stmt->fetchColumn();
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

    public static function hasLiked($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_like FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $likes = json_decode($stmt->fetchColumn(), true);

        return in_array($userId, $likes);
    }

    public static function addLike($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_like FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $likes = json_decode($stmt->fetchColumn(), true);

        // Ajouter l'ID de l'utilisateur à la liste des likes
        $likes[] = $userId;

        // Mettre à jour la colonne id_like dans la table post
        $stmt = $db->prepare("UPDATE post SET id_like = ? WHERE IDpost = ?");
        $stmt->execute([json_encode($likes), $postId]);

        // Ajouter un like au post
        $stmt = $db->prepare("UPDATE post SET aime = aime + 1 WHERE IDpost = ?");
        $stmt->execute([$postId]);
    }

    public static function removeLike($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_like FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $likes = json_decode($stmt->fetchColumn(), true);

        // Retirer l'ID de l'utilisateur de la liste des likes
        $likes = array_diff($likes, [$userId]);

        // Mettre à jour la colonne id_like dans la table post
        $stmt = $db->prepare("UPDATE post SET id_like = ? WHERE IDpost = ?");
        $stmt->execute([json_encode($likes), $postId]);

        // Retirer un like au post
        $stmt = $db->prepare("UPDATE post SET aime = aime - 1 WHERE IDpost = ?");
        $stmt->execute([$postId]);
    }

    // Dans votre classe Post
// Dans votre classe Post
    public static function hasDisliked($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_dislikes FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $disLikes = json_decode($stmt->fetchColumn(), true);

        return in_array($userId, $disLikes);
    }

    public static function addDislike($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_dislikes FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $dislikes = json_decode($stmt->fetchColumn(), true);

        // Ajouter l'ID de l'utilisateur à la liste des dislikes
        $dislikes[] = $userId;

        // Mettre à jour la colonne id_dislike dans la table post
        $stmt = $db->prepare("UPDATE post SET id_dislikes = ? WHERE IDpost = ?");
        $stmt->execute([json_encode($dislikes), $postId]);

        // Ajouter un dislike au post
        $stmt = $db->prepare("UPDATE post SET aimePas = aimePas + 1 WHERE IDpost = ?");
        $stmt->execute([$postId]);
    }

    public static function removeDislike($postId, $userId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT id_dislikes FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $dislikes = json_decode($stmt->fetchColumn(), true);

        // Retirer l'ID de l'utilisateur de la liste des dislikes
        $dislikes = array_diff($dislikes, [$userId]);

        // Mettre à jour la colonne id_dislike dans la table post
        $stmt = $db->prepare("UPDATE post SET id_dislikes = ? WHERE IDpost = ?");
        $stmt->execute([json_encode($dislikes), $postId]);

        // Retirer un dislike au post
        $stmt = $db->prepare("UPDATE post SET aimePas = aimePas - 1 WHERE IDpost = ?");
        $stmt->execute([$postId]);
    }

    public static function getPostById($postId)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM post WHERE IDpost = ?");
        $stmt->execute([$postId]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            return $post;
        } else {
            return null;
        }
    }

}

?>