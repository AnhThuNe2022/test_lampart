<?php

//require_once _DIR_ROOT.'/app/controllers/Product.php'; // Đảm bảo đã import lớp Product trước khi sử dụng
include('CategoryRepositoryInterface.php');

class CategoryRepository implements CategoryRepositoryInterface
{
    public $_table = 'category';
    private $db;

    public function __construct()
    {
        require_once _DIR_ROOT.'/configs/config.php';
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getList()
    {
        $stmt = $this->db->query('SELECT * FROM '.$this->_table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getAllProducts(): array
    // {
    //     $stmt = $this->db->query('SELECT * FROM product');
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function getProductById(int $id): ?array
    // {
    //     $stmt = $this->db->prepare('SELECT * FROM product WHERE id = :id');
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     $product = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $product ?: null;
    // }

    // public function addProduct(array $productData): bool
    // {
    //     $stmt = $this->db->prepare('INSERT INTO product (Name, Category, Image) VALUES (:name, :category, :image)');
    //     $stmt->bindParam(':name', $productData['name'], PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $productData['category'], PDO::PARAM_STR);
    //     $stmt->bindParam(':image', $productData['image'], PDO::PARAM_STR);
    //     return $stmt->execute();
    // }

    // public function updateProduct(int $id, array $productData): bool
    // {
    //     $stmt = $this->db->prepare('UPDATE product SET Name = :name, Category = :category, Image = :image WHERE id = :id');
    //     $stmt->bindParam(':name', $productData['name'], PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $productData['category'], PDO::PARAM_STR);
    //     $stmt->bindParam(':image', $productData['image'], PDO::PARAM_STR);
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }

    // public function deleteProduct(int $id): bool
    // {
    //     $stmt = $this->db->prepare('DELETE FROM product WHERE id = :id');
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }
}
?>