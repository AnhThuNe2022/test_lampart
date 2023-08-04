<?php
class Product {
    private $id;
    private $productName;
    private $category;
    private $image;


    public function __construct($id, $name, $categoryId,$image) {
        $this->id = $id;
        $this->productName = $name;
        $this->category = $categoryId;
        $this->image = $image;

    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }
}

?>