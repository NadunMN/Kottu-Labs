<?php

use app\core\Application;

class m0012_unreg_table
{
    public function up()
    {
        $db = Application::$app->db;

        // cart table
        $SQL = "CREATE TABLE unreguser (
            temp_id INT AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(255) NOT NULL,
            branch_id INT,
            email varchar(255) NOT NULL,
            reservation_date DATE NOT NULL,
            reservation_time TIME NOT NULL,
            guests INT NOT NULL,
            confirmation_status INT NOT NULL DEFAULT 0,
            type VARCHAR(255) NOT NULL,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $tables = [
            'unreguser' 
        ];
        foreach ($tables as $table) {
            $SQL = "DROP TABLE IF EXISTS $table;";
            $db->pdo->exec($SQL);
        }
    }
}
