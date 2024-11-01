<?php

use app\core\Application;

class m0003_add_type_column
{
    public function up()
    {
        $db = Application::$app->db;
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'type';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();

        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN type VARCHAR(255) NOT NULL;";
            $db->pdo->exec($SQL);
        }
    }

    public function down()
    {
        $db = Application::$app->db;
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'type';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();

        if ($result) {
            $SQL = "ALTER TABLE users DROP COLUMN type;";
            $db->pdo->exec($SQL);
        }
    }
}