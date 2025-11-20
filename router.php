<?php
require_once 'app/controllers/productosController.php';
require_once './app/controllers/authController.php';
require_once './app/controllers/categoriasController.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');


$action = 'home';
if (!empty($_GET["action"])){
    $action = $_GET["action"];
} 


$params = explode("/",$action);

switch ($params[0]) {
        //PRODUCTOS
    case 'home':
        $controller = new productosController();
        $controller->showHome();
        break;

    case 'actualizarProducto':
        $controller = new productosController();
        $controller->actualizarProducto($params[1]);
        break;
    
    case 'showProducto':
        $controller = new productosController();
        $controller->showProduct($params[1]);
        break;

    case 'editProducto':
        $controller = new productosController();
        $controller ->editProduct($params[1]); 
        break;

    case 'filtrarProducto':
        $controller = new productosController();
        $controller->filtrarProducto();
        break;
        
    case 'removeProduct': 
        $controller = new productosController();
        $controller-> removeProduct($params[1]);
        break;

    case 'addProduct':
        $controller = new productosController();
        $controller->addProduct();
        break;

        //CATEGORIAS
    case 'categorias':
        $controller = new categoriasController();
        $controller->showCategorias();
        break;
    case 'addCategoria':
        $controller = new categoriasController();
        $controller->addCategoria();
        break;
    case 'removeCategoria':
        $controller = new categoriasController();
        $controller ->removeCategoria($params[1]);
        break;
    case 'editCategoria':
        $controller = new categoriasController();
        $controller ->editCategoria($params[1]); 
        break;
    case 'actualizarCategoria':
        $controller = new categoriasController();
        $controller ->actualizarCategoria($params[1]);
        break;

    case 'auth':
        $controller = new authController();
        $controller->auth();
        break;

    case 'login':
        $controller = new authController();
        $controller->showLogin();
        break;

    case 'logout':
        $controller = new authController();
        $controller->logout();
        break;


    default:
        echo "Error 404";
        break;  
}


