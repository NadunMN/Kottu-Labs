<?php

use app\core\Application;

class m0005_column_offer
{
    public function up()
    {
        $db = Application::$app->db;

        // Add publish_status column
        $checkColumnSQL = "SHOW COLUMNS FROM offers LIKE 'publish_status';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE offers ADD COLUMN publish_status INT DEFAULT 0;";
            $db->pdo->exec($SQL);
        }


    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop publish_status column
        $SQL = "ALTER TABLE offers DROP COLUMN publish_status;";
        $db->pdo->exec($SQL);

       

    }
}