<?php
require_once './app/models/userModel.php';
require_once './app/views/authView.php';
require_once './app/helpers/authHelper.php';

class authController{
    private $view;
    private $model;

    function __construct(){
        $this->model = new userModel();
        $this->view = new authView();
    }

    function showLogin(){
        $this->view->showLogin();
    }

    function auth(){
        $usuario = $_POST['user'];
        $password = $_POST['password'];
        
        if (empty($usuario) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }
        $user = $this->model->getByUser($usuario);
        if ($user && password_verify($password, $user->password)) {
            
            AuthHelper::login($user);
            
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showLogin('user inválido');
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);    
    }

    
}