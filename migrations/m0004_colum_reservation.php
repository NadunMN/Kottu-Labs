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

        // Add reservation_name column
        $checkColumnSQL = "SHOW COLUMNS FROM reservations LIKE 'reservation_name';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE reservations ADD COLUMN reservation_name varchar(255);";
            $db->pdo->exec($SQL);
        }

        // Add type column
        $checkColumnSQL = "SHOW COLUMNS FROM reservations LIKE 'type';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE reservations ADD COLUMN type varchar(255);";
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

        // Drop reservation_name column
        $SQL = "ALTER TABLE reservations DROP COLUMN reservation_name;";
        $db->pdo->exec($SQL);

        // Drop type column
        $SQL = "ALTER TABLE reservations DROP COLUMN type;";
        $db->pdo->exec($SQL);

       

    }
}