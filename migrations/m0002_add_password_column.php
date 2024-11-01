<?php

use app\core\Application;

class m0002_add_password_column
{
    public function up()
    {
        $db = Application::$app->db;
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'password';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();

        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL;";
            $db->pdo->exec($SQL);
        }
    }

    public function down()
    {
        $db = Application::$app->db;
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'password';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();

        if ($result) {
            $SQL = "ALTER TABLE users DROP COLUMN password;";
            $db->pdo->exec($SQL);
        }
    }
}