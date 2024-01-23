<?php
require_once("index.php");
class User
{
    private $db;
    // Propriétés du modèle
    public $id;
    public $email;
    public $password; // Assurez-vous de stocker les mots de passe de manière sécurisée (par exemple, hachage et salage)
    public $first_name;
    public $last_name;
    public $birthdate;
    public $phone;
    public $Admin;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function setUserData($last_name, $first_name, $email, $password, $admin, $phone, $birthdate) {
        $this->last_name = mysqli_real_escape_string($this->db->getConnection(), $last_name);
        $this->first_name = mysqli_real_escape_string($this->db->getConnection(), $first_name);
        $this->email = mysqli_real_escape_string($this->db->getConnection(), $email);
        $this->password = mysqli_real_escape_string($this->db->getConnection(), $password);
        $this->admin = (int)$admin;
        $this->phone = mysqli_real_escape_string($this->db->getConnection(), $phone);
        $this->birthdate = mysqli_real_escape_string($this->db->getConnection(), $birthdate);
    }
    
    // Méthode pour enregistrer un nouvel utilisateur
    public function save()
    {
        if ($this->last_name && $this->first_name && $this->email && $this->password && isset($this->Admin) && $this->phone && $this->birthdate) {
            $sql = "INSERT INTO USERS (Nom, Prenom, Email, MDP, Admin, tel, date_naissance) 
                    VALUES ('$this->last_name', '$this->first_name', '$this->email', '$this->password', $this->Admin, '$this->phone', '$this->birthdate')";

            $result = mysqli_query($this->db->getConnection(), $sql);

            if ($result) {
                echo "Enregistrement réussi.";
            } else {
                echo "Erreur d'enregistrement: " . mysqli_error($this->db->getConnection());
            }
        } else {
            echo "Les données ne sont pas correctement définies.";
        }
    }
    

    // Méthode pour récupérer un utilisateur par son ID
    public static function getById($id)
    {
        //TODO
    }

}
