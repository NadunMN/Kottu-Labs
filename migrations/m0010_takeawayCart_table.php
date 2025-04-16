<?php

use app\core\Application;

class m0010_takeawayCart_table
{
    public function up()
    {
        $db = Application::$app->db;

        // cart table
        $SQL = "CREATE TABLE takeawayCart (
            user_id INT NOT NULL,
            meal_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            PRIMARY KEY (user_id, meal_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (meal_id) REFERENCES meals(meal_id) ON DELETE CASCADE
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
