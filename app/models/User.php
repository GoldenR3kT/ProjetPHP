<?php


class User
{

    // Propriétés du modèle
    public $email;
    public $password; // Assurez-vous de stocker les mots de passe de manière sécurisée (par exemple, hachage et salage)
    public $first_name;
    public $last_name;
    public $birthdate;
    public $phone;
    public $Admin;
    public $id;
    public $pseudo;
    public $img;



    public function __construct($data)
    {
        $this->id = $data['IDuser'];
        $this->email = $data['Email'];
        $this->password = $data['MDP'];
        $this->first_name = $data['Prenom'];
        $this->last_name = $data['Nom'];
        $this->birthdate = $data['date_naissance'];
        $this->phone = $data['tel'];
        $this->Admin = $data['Admin'];
        $this->pseudo= $data['pseudo'];
        $this->img= $data['img'];
    }

    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO users (Nom, Prenom, Email, MDP, Admin, tel, date_naissance,pseudo) VALUES ( ?,?, ?, ?, ?, ?, ?,?)");
        $stmt->execute([$this->last_name, $this->first_name, $this->email, $this->password, $this->Admin, $this->phone, $this->birthdate, $this->pseudo]);

    }

    
    // Méthode pour récupérer un utilisateur par son e-mail
    public static function getByEmail($email)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM users WHERE Email=?");
        $stmt->execute([$email]);

        // Afficher les résultats pour le débogage
        //var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? new User($user) : null;
    }

    public function __toString()
    {
        return sprintf(
            "User[id=%d, email=%s, first_name=%s, last_name=%s, birthdate=%s, phone=%s, Admin=%s]",
            $this->id,
            $this->email,
            $this->first_name,
            $this->last_name,
            $this->birthdate,
            $this->phone,
            $this->Admin ? 'true' : 'false'
        );
    }

    public static function getFirstNameById($id)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT Prenom FROM users WHERE IDuser=?");
        $stmt->execute([$id]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur avec l'ID donné existe
        if ($userData) {
            return $userData['Prenom'];
        } else {
            return null; // Retourner null si l'utilisateur n'est pas trouvé
        }
    }

    public static function searchUsersByName($searchTerm)
    {
        $db = include('../Database.php'); // Obtenez la connexion à la base de données

        // Requête SQL pour rechercher des utilisateurs par nom ou prénom
        $sql = "SELECT * FROM users WHERE pseudo LIKE ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$searchTerm]);

        // Récupérer les résultats de la recherche sous forme de tableau associatif
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourner les utilisateurs trouvés
        return $users;
    }

    // Dans votre classe User

    public static function getById($userId)
    {
        $db = include('../Database.php');

        $stmt = $db->prepare("SELECT * FROM users WHERE IDuser = ?");
        $stmt->execute([$userId]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userData ? new User($userData) : null;
    }


    public static function updateProfile($user,$userId, $pseudo, $email, $newPassword, $profileImage)
    {
        $db = include('../Database.php');

        // Vérifier si un nouveau mot de passe est fourni et le hacher si nécessaire
        if ($newPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            // Si aucun nouveau mot de passe n'est fourni, conserver le mot de passe existant
            $hashedPassword = $user->password; // Ou récupérez le mot de passe existant depuis la base de données
        }

        if(!$profileImage){
            $profileImage = $user->img;
        }
        // Préparer et exécuter la requête SQL
        $stmt = $db->prepare("UPDATE users SET pseudo = ?, Email = ?, MDP = ?, img = ? WHERE IDuser = ?");
        $stmt->execute([$pseudo, $email, $hashedPassword, $profileImage, $userId]);

        $user->id = $userId;
        $user->pseudo = $pseudo;
        $user->email = $email;
        $user->img = $profileImage;

    }




}



