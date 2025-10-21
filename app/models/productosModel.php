<?php 
require_once './config.php';
class productosModel{
    private $db;

    function __construct(){
        //PUERTO DE MYSQL MODIFICADO POR ERROR EN XAMMP: nuevo puerto 3307 y puerto original: 3306
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';port=3307;dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);

    }
    function getProducts(){
        $query = $this->db->prepare('SELECT a.* , b.* FROM productos a LEFT JOIN  categorias b ON a.categoria = b.id_categoria');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function insertProduct($producto, $categoria, $precio){
        $query = $this->db->prepare('INSERT INTO productos(nombre_producto, categoria, precio) VALUES(?,?,?)');
        $query->execute (array($producto, $categoria, $precio));

        return $this->db->lastInsertId();
    }
    
    function removeProduct($id){
        $query = $this->db->prepare('DELETE FROM productos WHERE id = ?');
        $query->execute([$id]);
    }

    function filtrarProducto($id){
        $query =$this->db->prepare('SELECT a.*, b.* FROM productos a LEFT JOIN categorias b ON a.categoria= b.id_categoria  WHERE b.id_categoria = ?');
        $query->execute(array($id));
        return  $query->fetchAll(PDO::FETCH_OBJ);
    
    }

    function showProducto($id){
        $query = $this->db->prepare('SELECT * FROM productos WHERE id = ?');
        $query->execute(array($id));
        return  $query->fetch(PDO::FETCH_OBJ);
    }

    function actualizarProducto($id,$nuevoNombre, $categoria, $precio){
        $query = $this->db->prepare("UPDATE productos SET nombre_producto='$nuevoNombre', categoria='$categoria',precio='$precio' WHERE id = ?");
        $query->execute(array($id));
    }


}