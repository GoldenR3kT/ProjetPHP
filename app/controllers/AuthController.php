<?php

require_once("Controller.php");
require_once("../models/User.php");

class AuthController extends Controller
{

    public function index()
    {
        echo "AuthController - Index";
    }

    // Méthode pour afficher le formulaire de connexion
    public function loginForm()
    {
        return $this->view('auth/login');
    }

    // Méthode pour traiter la soumission du formulaire de connexion
    public function login()
    {
        // Votre logique de validation et d'authentification ici
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Exemple basique de validation (à adapter selon votre modèle)
        if ($user = User::getByEmail($email)) {
            if (password_verify($password, $user->password)) {
                // Authentification réussie
                $_SESSION['user_id'] = $user->id;
                $_SESSION['pseudo'] = $user->pseudo;
                $_SESSION['email'] = $user->email;
                $_SESSION['first_name'] = $user->first_name;
                $_SESSION['last_name'] = $user->last_name;
                $_SESSION['img'] = $user->img;
                return $user;
            }
        }
        // Si l'authentification échoue, afficher un message d'erreur
        return $this->view('auth/login', ['error' => 'Invalid email or password']);

    }


    // Méthode pour afficher le formulaire d'inscription
    public function registerForm()
    {
        return $this->view('auth/register');
    }

    // Méthode pour traiter la soumission du formulaire d'inscription
    public function register()
    {
        // Votre logique d'enregistrement d'utilisateur ici
        // Assurez-vous de valider les données entrées par l'utilisateur

        $userData = [
            'IDuser' => null,  // Laissez IDuser comme null, car il sera généré automatiquement dans la base de données (suppose que c'est une clé primaire auto-incrémentée)
            'Email' => $_POST['email'],
            'MDP' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'Prenom' => $_POST['first_name'],
            'Nom' => $_POST['last_name'],
            'date_naissance' => $_POST['birthdate'],
            'tel' => $_POST['phone'],
            'Admin' => null, // Laissez Admin comme null par défaut, ou ajustez selon vos besoins
            'pseudo' => $_POST['pseudo']
        ];

        $user = new User($userData);
        $user->save(); // Enregistrement de l'utilisateur dans la base de données

        // Rediriger vers la page de connexion après l'inscription
        header('Location: ../views/auth/login.php');
        exit;
    }

    // Méthode pour déconnecter l'utilisateur
    public function logout()
    {
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        header('Location: /');
        exit;
    }
}
