<?php

use app\core\Application;

class m00013_addcolumn_payments
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM payments LIKE 'steward_id';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE payments ADD COLUMN steward_id INT NULL,
            ADD CONSTRAINT steward_user_payment FOREIGN KEY (steward_id) REFERENCES users(id) ON DELETE SET NULL;";
            $db->pdo->exec($SQL);
        }

    }

    public function down()
    {
        $db = Application::$app->db;


        // Drop confirmation_number column
        $SQL = "ALTER TABLE payments DROP COLUMN steward_id;";
        $db->pdo->exec($SQL)
        ;
 
    }
}