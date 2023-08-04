<?php

//require_once _DIR_ROOT.'/app/controllers/Product.php'; // Đảm bảo đã import lớp Product trước khi sử dụng
include('ProductRepositoryInterface.php');

class ProductRepository implements ProductRepositoryInterface
{
    public $_table = 'product';
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

     public function addProduct(array $productData): bool
     {
        //truy vấn INSERT vào cơ sở dữ liệu
        $sql = 'INSERT INTO product (Name, Category, Image) VALUES (:productName, :category, :image)';

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':productName', $productData['ProductName'], PDO::PARAM_STR);
        $stmt->bindParam(':category', $productData['Category'], PDO::PARAM_INT);
        $stmt->bindParam(':image', $productData['Image'], PDO::PARAM_STR);

        // Thực thi câu truy vấn và kiểm tra kết quả
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
     }

    // public function updateProduct(int $id, array $productData): bool
    // {
    //     $stmt = $this->db->prepare('UPDATE product SET Name = :name, Category = :category, Image = :image WHERE id = :id');
    //     $stmt->bindParam(':name', $productData['name'], PDO::PARAM_STR);
    //     $stmt->bindParam(':category', $productData['category'], PDO::PARAM_STR);
    //     $stmt->bindParam(':image', $productData['image'], PDO::PARAM_STR);
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }

     public function deleteProduct(int $id): bool
     {
         $stmt = $this->db->prepare('DELETE FROM product WHERE id = :id');
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
         return $stmt->execute();
     }


     public function searchProduct($keyword)
    {
        //câu truy vấn tìm kiếm sản phẩm
        $sql = 'SELECT * FROM product WHERE Name LIKE :keyword OR Category LIKE :keyword';
        $stmt = $this->db->prepare($sql);

        // Gán giá trị từ biến $keyword vào câu truy vấn
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);

        // Thực thi câu truy vấn và trả về kết quả
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductById(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }


    public function updateProduct(array $productData): bool
    {
        // Chuẩn bị câu truy vấn UPDATE vào cơ sở dữ liệu
        $sql = 'UPDATE product SET Name = :productName, Category = :category, Image = :image WHERE Id = :productId';
        $stmt = $this->db->prepare($sql);

        // Gán các giá trị từ $productData vào câu truy vấn
        $stmt->bindParam(':productId', $productData['productId'], PDO::PARAM_INT);
        $stmt->bindParam(':productName', $productData['productName'], PDO::PARAM_STR);
        $stmt->bindParam(':category', $productData['category'], PDO::PARAM_INT);
        $stmt->bindParam(':image', $productData['image'], PDO::PARAM_STR);

        // Thực thi câu truy vấn và kiểm tra kết quả
        if ($stmt->execute()) {
            // Nếu cập nhật thành công, trả về true
            return true;
        } else {
            // Nếu cập nhật không thành công, trả về false
            return false;
        }
    }
}
?>