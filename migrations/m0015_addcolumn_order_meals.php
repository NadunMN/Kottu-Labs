<?php

use app\core\Application;

class m0015_addcolumn_order_meals
{
    public function up()
    {
        $db = Application::$app->db;

        // Add stewaard_id column
        $checkColumnSQL = "SHOW COLUMNS FROM order_meals LIKE 'steward_id';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE order_meals ADD COLUMN steward_id INT NULL,
            ADD CONSTRAINT steward_order_eals FOREIGN KEY (steward_id) REFERENCES users(id) ON DELETE SET NULL;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;


        // Drop stewaard_id column
        $SQL = "ALTER TABLE order_meals DROP COLUMN steward_id;";
        $db->pdo->exec($SQL)
        ;
 
    }
}