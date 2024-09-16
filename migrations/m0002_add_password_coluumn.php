<?php

use app\core\Application;

class m0002_add_password_coluumn
{
    public function up()
    {
        $db=Application::$app->db;
        $SQL="ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db=Application::$app->db;
        $SQL="ALTER TABLE users DROP COLUMN password;";
        $db->pdo->exec($SQL);
    }
}

