<?php

class Controller
{
    protected function view($view, $data=[])
    {
        // Inclure le fichier de vue
        echo $data;
        require_once '../views/' . $view . '.php';
    }

    protected function model($model)
    {
        // Inclure le fichier du modèle
        require_once '../models/' . $model . '.php';

        // Instancier et retourner le modèle
        return new $model();
    }

    // Autres méthodes utilitaires nécessaires...

}
