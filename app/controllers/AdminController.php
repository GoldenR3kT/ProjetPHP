<?php
define('ROOT_PATH', dirname(__DIR__));

require_once("Controller.php");
require_once(ROOT_PATH . '/models/Admin.php');
class AdminController extends Controller
{
    public static function index()
    {
        return Admin::getAllUsers();
    }

    public static function deleteUser($idUser)
    {
        Admin::deleteUser($idUser);

    }

    public static function deletePost($idPost)
    {
        Admin::deletePost($idPost);
    }
}
