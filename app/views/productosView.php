<?php

class productosView {

    function showAdminProductsList($list, $categorias){
        $count = count ($list);
        require'./templates/productosAdmin.phtml';
    }
    function showProductsList($list, $categorias){
        $count = count ($list);
        $count = count($categorias);
        require './templates/productos.phtml';
    }
    function showProduct($productos, $categorias){
        require './templates/producto.phtml';
    }
    function showError($error) {
        require './templates/error.phtml';
    }
    function productoEdit($id,$producto,$listCategorias){
        require './templates/editProducto.phtml';
    }


}

