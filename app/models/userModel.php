<?php
require_once './config.php';
class userModel{
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';port=3307;dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    public function getByUser($user) {
        $query = $this->db->prepare('SELECT * FROM usuario WHERE user = ?');
        $query->execute([$user]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}