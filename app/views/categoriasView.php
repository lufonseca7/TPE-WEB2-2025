<?php
class categoriasView {

    function __construct(){}

    function showAdminCategoriasList($list){
        $count = count($list);
        require './templates/categoriasAdmin.phtml';
    }
    function showCategoriasList($list){
        $count = count($list);
        require './templates/categorias.phtml';
    }
   
    public function showError($error) {
        require './templates/error.phtml';
    }

    function categoriaEdit($id,$categoria){
        require './templates/editCategoria.phtml';
    }

}