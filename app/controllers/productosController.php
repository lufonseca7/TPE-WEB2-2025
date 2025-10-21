<?php
require_once './app/models/productosModel.php';
require_once './app/views/productosView.php';
require_once './app/models/categoriasModel.php';
require_once './app/helpers/authHelper.php';

class productosController{
    private $model;
    private $view;
    private $modelCategoria;

    function __construct(){
        $this->model = new productosModel();
        $this->view = new productosView();
        $this->modelCategoria = new categoriasModel();
    } 

    function showHome(){
        $list = $this->model->getProducts();
        $categoria = $this->modelCategoria->getCategorias();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminProductsList($list,$categoria);
        }
        else{
            $this->view->showProductsList($list,$categoria);
        }
    }

    function addProduct(){
        AuthHelper::verify();
        $producto = $_POST['producto'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];

        if (empty($producto)|| empty($precio)|| empty($categoria)){
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        $idProducto = $this->model->insertProduct($producto, $categoria, $precio);
        if ($idProducto){
            header('Location: ' . BASE_URL . 'home');
        }
        else{
            $this->view->showError("Error al inserter el producto ");
        }
    }
    
    function removeProduct($id){
        authHelper::verify();
        $this->model->removeProduct($id);
        header('Location: '. BASE_URL . 'home');
    }

    function filtrarProducto(){
        AuthHelper::init();
        $products= $this->model->getProducts();

        $list = $this->model->filtrarProducto($_POST['filtroCategoria']);
        if(empty($_POST["filtroCategoria"])){
            $this->view->showError("Seleccione una categoria");
            return;
        }
        if(empty ($list)){
            $this->view->showError("NO existen productos con esta categoria");
            return;
        }
        if(authHelper::checkLogin()){
            $this->view->showAdminProductsList($list, $products);
        }
        else{
            $this->view->showProductsList($list, $products);
        }

    }
        
        function editProduct($id){
        AuthHelper::verify();
        $categoria = $this->modelCategoria->getCategorias();
        $producto = $this->model->showProducto($id);
        $this->view->productoEdit($id,$producto,$categoria);
        }

        function actualizarProducto($id){
        AuthHelper::verify();
        $nuevoNombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        if (empty($nuevoNombre) || empty($precio)|| empty($categoria)) {
             $this->view->showError("complete todos los campos");
             return;
        }
        $this->model->actualizarProducto($id,$nuevoNombre, $categoria, $precio);
        header('Location: ' . BASE_URL .'home');
        }


}
    

