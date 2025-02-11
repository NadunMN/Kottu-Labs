<?php

use app\core\Application;

class m0002_add_mutiplecolumns_users
{
    public function up()
    {
        $db = Application::$app->db;

        // Add mobile_number column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'mobile_number';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN mobile_number VARCHAR(20) NOT NULL;";
            $db->pdo->exec($SQL);
        }

        // Add date_of_birth column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'date_of_birth';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN date_of_birth DATE DEFAULT NULL;";
            $db->pdo->exec($SQL);
        }

        // Add gender column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'gender';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN gender VARCHAR(10) NOT NULL;";
            $db->pdo->exec($SQL);
        }

        // Add address column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'address';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN address TEXT NOT NULL;";
            $db->pdo->exec($SQL);
        }

        // Add nationality column
        $checkColumnSQL = "SHOW COLUMNS FROM users LIKE 'nationality';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE users ADD COLUMN nationality VARCHAR(255) NOT NULL;";
            $db->pdo->exec($SQL);
        }


        
    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop nationality column
        $SQL = "ALTER TABLE users DROP COLUMN nationality;";
        $db->pdo->exec($SQL);

        // Drop address column
        $SQL = "ALTER TABLE users DROP COLUMN address;";
        $db->pdo->exec($SQL);

        // Drop gender column
        $SQL = "ALTER TABLE users DROP COLUMN gender;";
        $db->pdo->exec($SQL);

        // Drop date_of_birth column
        $SQL = "ALTER TABLE users DROP COLUMN date_of_birth;";
        $db->pdo->exec($SQL);

        // Drop mobile_number column
        $SQL = "ALTER TABLE users DROP COLUMN mobile_number;";
        $db->pdo->exec($SQL);

       

    }
}