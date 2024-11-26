<?php
class CProducts
{
    private $connection;

    public function __construct($host, $dbName, $username, $password)
    {
        // Подключение к базе данных
        $this->connection = new mysqli($host, $username, $password, $dbName);

        // Проверка подключения
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Метод для получения списка товаров
    public function getProducts($limit = 10)
    {
        $sql = "SELECT * FROM Products WHERE is_hidden = 0 ORDER BY DATE_CREATE DESC LIMIT ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Метод для скрытия товара
    public function hideProduct($productId)
    {
        $sql = "UPDATE Products SET is_hidden = 1 WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $productId);
        return $stmt->execute();
    }

    // Метод для обновления количества товара
    public function updateQuantity($productId, $quantity)
    {
        $sql = "UPDATE Products SET PRODUCT_QUANTITY = ? WHERE ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $quantity, $productId);
        return $stmt->execute();

}
}
?>