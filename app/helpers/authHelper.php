<?php

class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_USER'] = $user->user; 
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . 'login');
            die();
        }
    }
    public static function checkLogin(){
        AuthHelper::init();
        if(!isset($_SESSION['USER_ID'])){
            return false;
        }
        else{
            return true;
        }
    }
}
?>