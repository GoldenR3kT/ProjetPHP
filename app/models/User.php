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

    // Méthode pour enregistrer un nouvel utilisateur
    public function save()
    {
        // TODO Save dans la BDD
    }

    // Méthode pour récupérer un utilisateur par son ID
    public static function getById($id)
    {
        //TODO
    }

}
