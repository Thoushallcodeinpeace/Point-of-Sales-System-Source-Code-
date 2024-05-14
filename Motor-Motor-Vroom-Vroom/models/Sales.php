<?php
require_once __DIR__.'/../initialize.php';

class Sales
{
    public static function getTodaySales()
    {
        global $connection;

        $sql_command = ("
            SELECT 
                SUM(order_items.quantity * order_items.price) AS today,
                DATE_FORMAT(orders.created_at, '%Y-%m-%d') AS _date
            FROM 
                `order_items`
            INNER JOIN 
                orders ON order_items.order_id = orders.id 
            WHERE 
                DATE(orders.created_at) = CURDATE()
            GROUP BY 
                _date;
        ");

        $stmt = $connection->prepare($sql_command);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return $result[0]['today'];
        }

        return 0;
    }

    public static function getTotalSales()
    {
        global $connection;

        $sql_command = "SELECT SUM(quantity * price) AS total FROM order_items";

        $stmt = $connection->prepare($sql_command);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return $result[0]['total'];
        }

        return 0;
    }
}
?>
