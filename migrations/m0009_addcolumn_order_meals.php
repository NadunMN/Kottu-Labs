<?php

use app\core\Application;

class m0009_addcolumn_order_meals
{
    public function up()
    {
        $db = Application::$app->db;

        // Add user_id column
        $checkColumnSQL = "SHOW COLUMNS FROM order_meals LIKE 'user_id';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE order_meals ADD COLUMN user_id INT NOT NULL,
            ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ;";
            $db->pdo->exec($SQL);
        }

        // Add meal_status column
        $checkColumnSQL = "SHOW COLUMNS FROM order_meals LIKE 'status';";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "ALTER TABLE order_meals ADD COLUMN status varchar(255) NOT NULL;";
            $db->pdo->exec($SQL);
        }


    }

    public function down()
    {
        $db = Application::$app->db;

        // Drop confirmation_number column
        $SQL = "ALTER TABLE order_meals DROP COLUMN user_id;";
        $db->pdo->exec($SQL)
        ;
        // Drop confirmation_number column
        $SQL = "ALTER TABLE order_meals DROP COLUMN status;";
        $db->pdo->exec($SQL);

    }
}