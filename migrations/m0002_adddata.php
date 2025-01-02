<?php

use app\core\Application;

class m0002_adddata{
    public function up()
    {
        $db = Application::$app->db;

        // Add branches data
        $checkColumnSQL = "SELECT * FROM `branches`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO branches (branch_id, branch_name)
                    VALUES
                    (1, 'Wattala'),
                    (2, 'Kelaniya'),
                    (3, 'Kotahena');";
            $db->pdo->exec($SQL);
        }


        // Add menu data
        $checkColumnSQL = "SELECT * FROM `menus`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO menus (menu_id, branch_id)
                    VALUES
                    (1, 1),
                    (2, 2),
                    (3, 3);";
            $db->pdo->exec($SQL);
        }
    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop branches table
        $SQL = "DROP TABLE IF EXISTS branches;";
        $db->pdo->exec($SQL);
    }
}