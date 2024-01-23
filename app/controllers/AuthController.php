<?php

    include("Controller.php");
    include("../models/User.php");
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
                // Rediriger vers la page d'accueil ou une autre page après la connexion
                header('Location: ../views/social/create.php');
                exit;
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

        $user = new User();
        $user->email = $_POST['email'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage sécurisé du mot de passe
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->birthdate = $_POST['birthdate'];
        $user->phone = $_POST['phone'];

        $user->save(); // Enregistrement de l'utilisateur dans la base de données

        echo "stp marche";
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
