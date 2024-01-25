<?php

class Friendship
{
    // Propriétés du modèle
    public $IDami ;
    public $IDuser1 ;

    public $IDuser2 ;
    public $Statut;


    public function __construct($data)
    {
        $this->IDami = $data['IDami'];
        $this->IDuser1 = $data['IDuser1'];
        $this->IDuser2 = $data['IDuser2'];
        $this->Statut = $data['Statut'];

    }

    // Méthode pour ajouter une relation d'amitié entre deux utilisateurs
    public static function addFriendship($userID1, $userID2)
    {
        $db = include('../Database.php'); // Connexion à la base de données

        try {
            // Préparer la requête SQL pour insérer une nouvelle relation d'amitié
            $stmt = $db->prepare("INSERT INTO ami (IDuser1, IDuser2) VALUES (?, ?)");
            $stmt->execute([$userID1, $userID2]);
            // Si besoin, tu peux ajouter des validations ou des vérifications supplémentaires ici

            return true; // Retourne vrai si l'ajout est réussi
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            return false; // Retourne faux si une erreur survient
        }
    }

    // Méthode pour supprimer une relation d'amitié entre deux utilisateurs
    public static function removeFriendship($userID1, $userID2)
    {
        $db = include('../Database.php'); // Connexion à la base de données

        try {
            // Préparer la requête SQL pour supprimer la relation d'amitié
            $stmt = $db->prepare("DELETE FROM ami WHERE (IDuser1 = ? AND IDuser2 = ?) OR (IDuser1 = ? AND IDuser2 = ?)");
            $stmt->execute([$userID1, $userID2, $userID2, $userID1]);
            // Si besoin, tu peux ajouter des validations ou des vérifications supplémentaires ici

            return true; // Retourne vrai si la suppression est réussie
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            return false; // Retourne faux si une erreur survient
        }
    }

    // Méthode pour récupérer la liste des amis d'un utilisateur
    public static function getFriends($userID)
    {
        $db = include('../Database.php');

        try {
            $stmt = $db->prepare("SELECT Users.Nom, Users.Prenom, Users.IDuser  FROM ami JOIN Users ON ami.IDuser2 = Users.IDuser WHERE ami.IDuser1 = ?");
            $stmt->execute([$userID]);
            $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $friends;
        } catch (PDOException $e) {
            return [];
        }
    }

}


