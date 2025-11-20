<?php
require_once './app/models/categoriasModel.php';
require_once './app/views/categoriasView.php';
require_once './app/helpers/authHelper.php';

class categoriasController{
     private $view;
    private $model;

    function __construct() {
        $this->model = new categoriasModel();
        $this->view = new categoriasView();
}

 function showCategorias() {
        $list = $this->model->getCategorias();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminCategoriasList($list);
        }
        else{
            $this->view->showCategoriasList($list);
        }
    }

     function addCategoria() {
        AuthHelper::verify();
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria_destacada = $_POST['categoria_destacada'];
        
        
        if (empty($nombre)||empty($descripcion)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }
        $id_categoria = $this->model->insertCategoria($nombre,$descripcion,$categoria_destacada);
        if ($id_categoria) {
            header('Location: ' . BASE_URL . 'categorias');
        } else {
            $this->view->showError("Error al insertar la categoria");
        }
    }


     function removeCategoria($id_categoria){
        AuthHelper::verify();
        $this->model->removeCategoria($id_categoria);
        header('Location: ' . BASE_URL . 'categorias');

    } 


      function editCategoria($id_categoria){
        AuthHelper::verify();
        if (!$this->model->existeCategoria($id_categoria)) {
            $this->view->showError("Debe ingresar una categoria existente");
            return;
        }
        $categoria = $this->model->showCategoria($id_categoria);
        $this->view->categoriaEdit($id_categoria,$categoria);
    }

     function actualizarCategoria($id_categoria){
        AuthHelper::verify();
        $nuevoNombre = $_POST['nombre'];
        if (empty($this->model->showCategoria($id_categoria))) {
            $this->view->showError("Debe ingresar una categoria existente");
            return;
        }
        $this->model->actualizarCategoria($id_categoria,$nuevoNombre);
        header('Location: ' . BASE_URL .'categorias');

       
    }
}