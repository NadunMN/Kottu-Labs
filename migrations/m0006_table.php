<?php

use app\core\Application;

class m0006_table
{
    public function up()
    {
        $db = Application::$app->db;

        // order_meals table
        $SQL = "CREATE TABLE order_meals (
            om_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            meal_id INT NULL,
            offer_id INT NULL,
            quantity INT NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
            FOREIGN KEY (offer_id) REFERENCES offers(offer_id) ON DELETE CASCADE,
            FOREIGN KEY (meal_id) REFERENCES meals(meal_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $tables = [
            'order_meals' 
        ];
        foreach ($tables as $table) {
            $SQL = "DROP TABLE IF EXISTS $table;";
            $db->pdo->exec($SQL);
        }
    }
}
