<?php
require_once './config.php';
class productosModel
{
    private $db;

    function __construct()
    {
        //PUERTO DE MYSQL MODIFICADO POR ERROR EN XAMMP: nuevo puerto 3307 y puerto original: 3306
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';port=3307;dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->_deploy();
    }

    private function _deploy()
    {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        $password = 'admin';
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
        if (count($tables) == 0) {
            $sql = <<<END
            SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
            START TRANSACTION;
            SET time_zone = "+00:00";
                    
            CREATE TABLE `categorias` (
              `id_categoria` int(11) NOT NULL,
              `nombre_categoria` varchar(30) NOT NULL,
              `descripcion` varchar(250) NOT NULL,
              `categoria_destacada` tinyint(1) NOT NULL DEFAULT 1
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                    
            INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`, `categoria_destacada`) VALUES
            (1, 'Teclado', 'Teclados mecanicos y de membrana', 1),
            (2, 'Procesadores', 'Procesadores AMD e Intel', 0),
            (13, 'motherboard', 'Motherboard para AMD e INTEL', 0);
                    
            CREATE TABLE `productos` (
              `id` int(11) NOT NULL,
              `nombre_producto` varchar(70) NOT NULL,
              `categoria` int(70) NOT NULL,
              `precio` int(8) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                    
            INSERT INTO `productos` (`id`, `nombre_producto`, `categoria`, `precio`) VALUES
            (2, 'Teclado Mecanico TKL', 1, 60000),
            (3, 'INTEL i5 12400f', 2, 500000),
            (4, 'Teclado Mecanico 60%', 1, 430000),
            (7, 'Asus B350M', 13, 100000),
            (8, 'AMD Ryzen 7 8700', 2, 300000),
            (9, 'Gigabyte A520M-H', 13, 200000);
                    
            CREATE TABLE `usuario` (
              `id` int(11) NOT NULL,
              `user` varchar(50) NOT NULL,
              `password` char(60) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                    
            INSERT INTO `usuario` (`id`, `user`, `password`) VALUES
            (1, 'webadmin', '$hashedpassword');
            ALTER TABLE `categorias`
              ADD PRIMARY KEY (`id_categoria`);
            ALTER TABLE `productos`
              ADD PRIMARY KEY (`id`),
              ADD KEY `fk_productos_categorias` (`categoria`);
            ALTER TABLE `usuario`
              ADD PRIMARY KEY (`id`);
            ALTER TABLE `categorias`
              MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
            ALTER TABLE `productos`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
            ALTER TABLE `usuario`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
            ALTER TABLE `productos`
              ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`);
            COMMIT;
            END;

            $this->db->query($sql);
        }
    }

    function getProducts()
    {
        $query = $this->db->prepare('SELECT a.* , b.* FROM productos a LEFT JOIN  categorias b ON a.categoria = b.id_categoria');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function insertProduct($producto, $categoria, $precio)
    {
        $query = $this->db->prepare('INSERT INTO productos(nombre_producto, categoria, precio) VALUES(?,?,?)');
        $query->execute(array($producto, $categoria, $precio));

        return $this->db->lastInsertId();
    }

    function removeProduct($id)
    {
        $query = $this->db->prepare('DELETE FROM productos WHERE id = ?');
        $query->execute([$id]);
    }

    function filtrarProducto($id)
    {
        $query = $this->db->prepare('SELECT a.*, b.* FROM productos a LEFT JOIN categorias b ON a.categoria= b.id_categoria  WHERE b.id_categoria = ?');
        $query->execute(array($id));
        return  $query->fetchAll(PDO::FETCH_OBJ);
    }

    function showProducto($id)
    {
        $query = $this->db->prepare('SELECT * FROM productos WHERE id = ?');
        $query->execute(array($id));
        return  $query->fetch(PDO::FETCH_OBJ);
    }

    function actualizarProducto($id, $nuevoNombre, $categoria, $precio)
    {
        $query = $this->db->prepare("UPDATE productos SET nombre_producto='$nuevoNombre', categoria='$categoria',precio='$precio' WHERE id = ?");
        $query->execute(array($id));
    }
}
