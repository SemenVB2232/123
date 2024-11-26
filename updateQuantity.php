<?php
require 'CProducts.php';

// Подключение к базе данных
$productsClass = new CProducts('localhost', 'products', 'root', ''); 

// Получаем данные из POST-запроса
$productId = isset($_POST['id']) ? intval($_POST['id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($productId > 0) {
    $result = $productsClass->updateQuantity($productId, $quantity);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось обновить количество']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Некорректные данные']);
}
?>