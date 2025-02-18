<?php

use app\core\Application;

class m0004_colum_reservation
{
    public function up()
    {
        $db = Application::$app->db;

        // Add confirmation_number column
        $checkColumnSQL = "SHOW COLUMNS FROM reservations LIKE 'confirmation_number';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE reservations ADD COLUMN confirmation_number VARCHAR(20) NOT NULL;";
            $db->pdo->exec($SQL);
        }

        // Add table_number column
        $checkColumnSQL = "SHOW COLUMNS FROM reservations LIKE 'table_number';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE reservations ADD COLUMN table_number INT;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE reservations DROP COLUMN confirmation_number;";
        $db->pdo->exec($SQL);

        // Drop table_number column
        $SQL = "ALTER TABLE reservations DROP COLUMN table_number;";
        $db->pdo->exec($SQL);

       

    }
}