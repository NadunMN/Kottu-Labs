<?php

use app\core\Application;

class m0014_adddcolumn_reservation
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM reservations LIKE 'temp_id';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE reservations ADD COLUMN temp_id INT NULL,
            ADD CONSTRAINT temp_reservation FOREIGN KEY (temp_id) REFERENCES unreguser(temp_id) ON DELETE SET NULL;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;


        // Drop confirmation_number column
        $SQL = "ALTER TABLE reservations DROP COLUMN temp_id;";
        $db->pdo->exec($SQL)
        ;
 
    }
}