<?php

use app\core\Application;

class m0012_unreg_column
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM unreguser LIKE 'table_number';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE unreguser ADD COLUMN table_number INT NULL;";
            $db->pdo->exec($SQL);
        }

       
    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE unreguser DROP COLUMN table_number;";
        $db->pdo->exec($SQL)
        ;

      
    }
}