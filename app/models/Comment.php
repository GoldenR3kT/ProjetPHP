<?php


class Comment
{


    // Propriétés du modèle
    public $IDcommentaire ;
    public $IDpost ; // Assurez-vous de stocker les mots de passe de manière sécurisée (par exemple, hachage et salage)
    public $IDuser ;
    public $commentaire;



    public function __construct($data)
    {
        $this->IDcommentaire = $data['IDcommentaire'];
        $this->IDpost = $data['IDpost'];
        $this->IDuser = $data['$IDuser'];
        $this->commentaire = $data['$commentaire'];

    }


    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO USERS (commentaire) VALUES (?)");
        $stmt->execute([$this->commentaire]);

    }


}


