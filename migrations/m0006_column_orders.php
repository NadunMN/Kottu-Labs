<?php

use app\core\Application;

class m0006_column_orders
{
    public function up()
    {
        $db = Application::$app->db;

        // Add order_time column
        $checkColumnSQL = "SHOW COLUMNS FROM orders LIKE 'order_time';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE orders ADD COLUMN order_time DATE NOT NULL;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE orders DROP COLUMN order_time;";
        $db->pdo->exec($SQL);

       

       

    }
}