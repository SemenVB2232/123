<?php
require 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productsClass = new CProducts('localhost', 'products', 'root', '');
    $productId = $_POST['id'];
    
    $result = $productsClass->hideProduct($productId);
    echo json_encode(['success' => $result]);
}
?>