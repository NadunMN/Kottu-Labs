<?php

use app\core\Application;

class m0010_addcolumn_user
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'photo';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN photo VARCHAR(255);";
            $db->pdo->exec($SQL);
        }


    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE users DROP COLUMN photo;";
        $db->pdo->exec($SQL);
       

    }
}