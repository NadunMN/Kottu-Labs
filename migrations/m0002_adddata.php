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

        // Add users data
        $checkColumnSQL = "SELECT * FROM `users`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO users (email, firstname, lastname, status, position,mobile_number, branch_id)
                    VALUES
                    ('admin@gmail.com', 'Nadun', 'Madusanka', 1, 'admin','+94764659122', 1),
                    ('customer@gmail.com', 'Ranuga', 'Lekawasam', 0, 'customer','+94764659123', 2),
                    ('steward@gmail.com', 'Mahesh', 'Kumara', 0, 'steward','+94764659124', 3),
                    ('manager@gmail.com', 'Thirani', 'Athukorala', 0, 'manager','+94764659125', 1);";
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