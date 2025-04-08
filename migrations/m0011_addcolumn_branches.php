<?php

use app\core\Application;

class m0011_addcolumn_branches
{
    public function up()
    {
        $db = Application::$app->db;

        // Add quantity column
        $checkColumnSQL = "SHOW COLUMNS FROM branches LIKE 'seats';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE branches ADD COLUMN seats INT NOT NULL;";
            $db->pdo->exec($SQL);
        }


    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE branches DROP COLUMN seats;";
        $db->pdo->exec($SQL);
       

    }
}