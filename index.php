<?php
require 'CProducts.php';

// Подключаемся к базе данных
$productsClass = new CProducts('localhost', 'products', 'root', ''); 
$products = $productsClass->getProducts();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Список товаров</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название товара</th>
                <th>Цена</th>
                <th>Артикул</th>
                <th>Количество</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="productTable">
            <?php foreach ($products as $product): ?>
                <tr data-id="<?= $product['ID'] ?>">
                    <td><?= $product['ID'] ?></td>
                    <td><?= $product['PRODUCT_NAME'] ?></td>
                    <td><?= $product['PRODUCT_PRICE'] ?></td>
                    <td><?= $product['PRODUCT_ARTICLE'] ?></td>
                    <td>
                        <button class="decrement">-</button>
                        <span class="quantity"><?= $product['PRODUCT_QUANTITY'] ?></span>
                        <button class="increment">+</button>
                    </td>
                    <td><?= $product['DATE_CREATE'] ?></td>
                    <td>
                        <button class="hideButton">Скрыть</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Увеличение количества
            $(document).on('click', '.increment', function() {
                let row = $(this).closest('tr');
                let quantitySpan = row.find('.quantity');
                let productId = row.data('id');
                let currentQuantity = parseInt(quantitySpan.text());
                let newQuantity = currentQuantity + 1;

                // AJAX-запрос на обновление количества
                $.ajax({
                    url: 'updateQuantity.php',
                    type: 'POST',
                    data: { id: productId, quantity: newQuantity },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            quantitySpan.text(newQuantity); // Обновляем количество на странице
                        } else {
                            alert('Ошибка при обновлении количества: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ошибка соединения: ' + error);
                    }
                });
            });

            // Уменьшение количества
            $(document).on('click', '.decrement', function() {
                let row = $(this).closest('tr');
                let quantitySpan = row.find('.quantity');
                let productId = row.data('id');
                let currentQuantity = parseInt(quantitySpan.text());
                let newQuantity = Math.max(0, currentQuantity - 1);

                // AJAX-запрос на обновление количества
                $.ajax({
                    url: 'updateQuantity.php',
                    type: 'POST',
                    data: { id: productId, quantity: newQuantity },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            quantitySpan.text(newQuantity); // Обновляем количество на странице
                        } else {
                            alert('Ошибка при обновлении количества: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ошибка соединения: ' + error);
                    }
                });
            });

            // Скрытие строки
            $(document).on('click', '.hideButton', function() {
                let row = $(this).closest('tr');
                let productId = row.data('id');

                // AJAX-запрос на скрытие товара
                $.ajax({
                    url: 'hideProduct.php',
                    type: 'POST',
                    data: { id: productId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            row.remove(); // Удаляем строку из таблицы
                        } else {
                            alert('Ошибка при скрытии товара: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Ошибка соединения: ' + error);
                    }
                });
            });
        });
    </script>
</body>
</html>