<?php

use app\core\Application;

class m0003_adddata{
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
                    ('manager@gmail.com', 'Thirani', 'Athukorala', 0, 'manager','+94764659125', 1),
                    ('chef@gmail.com', 'Eraji', 'Thenuwara', 0, 'chef','+94764659125', 1);";
            $db->pdo->exec($SQL);
        }


        // Add meals data
        $checkColumnSQL = "SELECT * FROM `meals`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO meals (meal_name, meal_price, meal_description, meal_photo) VALUES
                    ('Meal 1', 1000.00, 'All', '/Photo/Menu/meal1.jpg'),
                    ('Meal 2', 1200.00, 'Classic Kottu', '/Photo/Menu/meal2.jpg'),
                    ('Meal 3', 1300.00, 'Dolphin Kottu', '/Photo/Menu/meal3.jpg'),
                    ('Meal 4', 1400.00, 'Cheese Kottu', '/Photo/Menu/meal4.jpg'),
                    ('Meal 5', 1250.00, 'String Hopper Kottu', '/Photo/Menu/meal5.jpg'),
                    ('Meal 6', 1500.00, 'KL Special Fried Rice', '/Photo/Menu/meal6.jpg'),
                    ('Meal 7', 1350.00, 'Pasta', '/Photo/Menu/meal7.jpg'),
                    ('Meal 8', 800.00, 'Appetizers', '/Photo/Menu/meal8.jpg'),
                    ('Meal 9', 1600.00, 'KL Inventions', '/Photo/Menu/meal9.jpg'),
                    ('Meal 10', 1100.00, 'Wraps & Rotti Sandwiches', '/Photo/Menu/meal10.jpg'),
                    ('Meal 11', 950.00, 'Parata', '/Photo/Menu/meal11.jpg'),
                    ('Meal 12', 1450.00, 'Devilled Portions', '/Photo/Menu/meal12.jpg'),
                    ('Meal 13', 700.00, 'Mocktails', '/Photo/Menu/meal13.jpg'),
                    ('Meal 14', 650.00, 'Beverages', '/Photo/Menu/meal14.jpg');";
            $db->pdo->exec($SQL);
        }


        // Add branch_meal data
        $checkColumnSQL = "SELECT * FROM `branch_meals`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO branch_meals (meal_id, branch_id, meal_status) VALUES
                    (1, 1, 1), (2, 1, 1), (3, 1, 1), (4, 1, 1),
                    (5, 1, 1), (6, 1, 1), (7, 1, 1), (8, 1, 1),

                    (3, 2, 1), (4, 2, 1), (5, 2, 1), (6, 2, 1),
                    (9, 2, 1), (10, 2, 1), (11, 2, 1), (12, 2, 1),

                    (2, 3, 1), (4, 3, 1), (6, 3, 1), (8, 3, 1),
                    (9, 3, 1), (12, 3, 1), (13, 3, 1), (14, 3, 1);";
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