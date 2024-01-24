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
    public $Admin = false;
    public $id;


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
    }


    // Méthode pour enregistrer un nouvel utilisateur

    public function save()
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("INSERT INTO USERS (Nom, Prenom, Email, MDP, Admin, tel, date_naissance) VALUES ( ?,?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->last_name, $this->first_name, $this->email, $this->password, $this->Admin, $this->phone, $this->birthdate]);

    }


    // Méthode pour récupérer un utilisateur par son e-mail
    public static function getByEmail($email)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM USERS WHERE Email=?");
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

}


?>
