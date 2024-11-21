<?php

use app\core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL DEFAULT 0,
            position VARCHAR(20) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        $SQL = "CREATE TABLE IF NOT EXISTS reviews (
            review_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            rating INT NOT NULL,
            review VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
                $db->pdo->exec($SQL);


       
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE IF EXISTS users;";
        $db->pdo->exec($SQL);

        $SQL = "DROP TABLE IF EXISTS reviews;";
        $db->pdo->exec($SQL);

       
    }
}