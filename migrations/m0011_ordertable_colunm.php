<?php

use app\core\Application;

class m0011_ordertable_colunm
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM orders LIKE 'chef_id';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE orders ADD COLUMN chef_id INT,
            ADD CONSTRAINT chef_user FOREIGN KEY (chef_id) REFERENCES users(id) ON DELETE CASCADE;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE orders DROP COLUMN chef_id;";
        $db->pdo->exec($SQL)
        ;
 

    }
}