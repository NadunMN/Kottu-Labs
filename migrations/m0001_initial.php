<?php

use app\core\Application;

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;

        // branches table
        $SQL = "CREATE TABLE IF NOT EXISTS branches (
            branch_id INT AUTO_INCREMENT PRIMARY KEY,
            branch_name VARCHAR(255) NOT NULL
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // users table
        $SQL = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL DEFAULT 0,
            position VARCHAR(20) NOT NULL,
            branch_id INT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE,
            INDEX (branch_id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
                                                            
        // reviews table
        $SQL = "CREATE TABLE IF NOT EXISTS reviews (
            review_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            rating INT NOT NULL,
            review TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX (user_id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // reservations table
        $SQL = "CREATE TABLE IF NOT EXISTS reservations (
            reservation_no INT AUTO_INCREMENT PRIMARY KEY,
            reservation_date VARCHAR(255) NOT NULL,
            reservation_time VARCHAR(255) NOT NULL,
            number_of_guests INT NOT NULL,
            confirmation_status TINYINT NOT NULL DEFAULT 0,
            branch_id INT NOT NULL,
            user_id INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE,
            INDEX (branch_id),
            INDEX (user_id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // payments table
        $SQL = "CREATE TABLE IF NOT EXISTS payments (
            payment_id INT AUTO_INCREMENT PRIMARY KEY,
            payment_date DATE NOT NULL,
            payment_type VARCHAR(255) NOT NULL,
            payment_amount DECIMAL(10,2) NOT NULL,
            payment_status TINYINT NOT NULL DEFAULT 0,
            user_id INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // orders table
        $SQL = "CREATE TABLE IF NOT EXISTS orders (
            order_id INT AUTO_INCREMENT PRIMARY KEY,
            order_date DATE NOT NULL,
            order_type VARCHAR(255) NOT NULL,
            order_status TINYINT NOT NULL DEFAULT 0,
            payment_id INT NOT NULL,
            branch_id INT NOT NULL,
            reservation_no INT DEFAULT NULL,
            user_id INT NOT NULL,
            FOREIGN KEY (payment_id) REFERENCES payments(payment_id) ON DELETE CASCADE,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE,
            FOREIGN KEY (reservation_no) REFERENCES reservations(reservation_no) ON DELETE SET NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX (payment_id),
            INDEX (branch_id),
            INDEX (reservation_no),
            INDEX (user_id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // offers table
        $SQL = "CREATE TABLE IF NOT EXISTS offers (
            offer_id INT AUTO_INCREMENT PRIMARY KEY,
            offer_name VARCHAR(255) NOT NULL,
            offer_price DECIMAL(10,2) NOT NULL,
            offer_description TEXT NOT NULL,
            offer_photo VARCHAR(255) NOT NULL
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // branch_offers table
        $SQL = "CREATE TABLE branch_offers (
            offer_id INT NOT NULL,
            branch_id INT NOT NULL,
            PRIMARY KEY (offer_id, branch_id),
            FOREIGN KEY (offer_id) REFERENCES offers(offer_id) ON DELETE CASCADE,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);


        // menu table
        // $SQL = "CREATE TABLE IF NOT EXISTS menus (
        //     menu_id INT AUTO_INCREMENT PRIMARY KEY,
        //     branch_id INT NOT NULL,
        //     FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE,
        //     INDEX (branch_id)
        // ) ENGINE=INNODB;";
        // $db->pdo->exec($SQL);

        // meals table
        $SQL = "CREATE TABLE IF NOT EXISTS meals (
            meal_id INT AUTO_INCREMENT PRIMARY KEY,
            meal_name VARCHAR(255) NOT NULL,
            meal_price DECIMAL(10,2) NOT NULL,
            meal_description TEXT NOT NULL,
            meal_photo VARCHAR(255) NOT NULL
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // meal_offers table
        $SQL = "CREATE TABLE meal_offers (
            meal_id INT NOT NULL,
            offer_id INT NOT NULL,
            PRIMARY KEY (meal_id, offer_id),
            FOREIGN KEY (meal_id) REFERENCES meals(meal_id) ON DELETE CASCADE,
            FOREIGN KEY (offer_id) REFERENCES offers(offer_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // branch_meals table
        $SQL = "CREATE TABLE branch_meals (
            meal_id INT NOT NULL,
            branch_id INT NOT NULL,
            meal_status TINYINT NOT NULL DEFAULT 0,
            PRIMARY KEY (meal_id, branch_id),
            FOREIGN KEY (meal_id) REFERENCES meals(meal_id) ON DELETE CASCADE,
            FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);

        // order_items table
        $SQL = "CREATE TABLE order_items (
            order_id INT NOT NULL,
            order_details INT NOT NULL,
            PRIMARY KEY (order_id, order_details),
            FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $tables = [
            'order_items', 'meal_offers', 'offers','branch_offers', 'meals', 'orders', 'payments', 
            'reservations', 'reviews', 'users', 'branches', 'menus', 'branch_meals' 
        ];
        foreach ($tables as $table) {
            $SQL = "DROP TABLE IF EXISTS $table;";
            $db->pdo->exec($SQL);
        }
    }
}
