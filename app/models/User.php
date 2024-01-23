<?php

class User
{
    protected $table = 'users';

    // Propriétés du modèle
    public $id;
    public $email;
    public $password; // Assurez-vous de stocker les mots de passe de manière sécurisée (par exemple, hachage et salage)
    public $first_name;
    public $last_name;
    public $birthdate;
    public $phone;
    public $Admin

    // Méthode pour enregistrer un nouvel utilisateur
    public function save()
    {
        if($_POST)
            executeRequete("INSERT INTO USERS (Nom, Prenom, Email, MDP, Admin, tel, date_naissance) VALUES ('$_POST[last_name]', '$_POST[first_name]', '$_POST[Email]', '$_POST[password]', $_POST[Admin], $_POST[phone],$_POST[birthdate])");
        else
            echo "ca marche pas le sang";
    }
    

    // Méthode pour récupérer un utilisateur par son ID
    public static function getById($id)
    {
        //TODO
    }

}
