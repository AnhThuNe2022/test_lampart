<?php

interface ProductRepositoryInterface
{
    public function getList();

    // public function getProductById(int $id): ?array;

    public function addProduct(array $productData): bool;

    // public function updateProduct(int $id, array $productData): bool;

    public function deleteProduct(int $id): bool;
    public function searchProduct(string $keyword);
    public function getProductById(int $id);
    public function updateProduct(array $productData): bool;

}

?>