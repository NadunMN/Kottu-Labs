<?php

use app\core\Application;

class m0008_cart_table
{
    public function up()
    {
        $db = Application::$app->db;

        // cart table
        $SQL = "CREATE TABLE cart (
             cart_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            meal_id INT,
            offer_id INT,
            quantity INT NOT NULL DEFAULT 1,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (meal_id) REFERENCES meals(meal_id) ON DELETE CASCADE,
            FOREIGN KEY (offer_id) REFERENCES offers(offer_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $tables = [
            'cart' 
        ];
        foreach ($tables as $table) {
            $SQL = "DROP TABLE IF EXISTS $table;";
            $db->pdo->exec($SQL);
        }
    }
}
