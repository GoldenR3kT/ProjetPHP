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
    public $Admin=false;



    // Méthode pour enregistrer un nouvel utilisateur


    public function save()
    {
        $db = include('../Database.php');
            $stmt = $db->prepare("INSERT INTO USERS (Nom, Prenom, Email, MDP, Admin, tel, date_naissance) VALUES ( ?,?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->last_name,$this->first_name, $this->email, $this->password, $this->Admin, $this->phone, $this->birthdate]);

    }


    // Méthode pour récupérer un utilisateur par son ID
    public static function getByEmail($email)
    {
        $db = include('../Database.php');
        $stmt = $db->prepare("SELECT * FROM USERS WHERE Email=?");
        $stmt->execute([$email]);
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>
