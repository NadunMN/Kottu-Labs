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
            $SQL = "INSERT INTO branches (branch_id, branch_name,seats)
                    VALUES
                    (1, 'Wattala',50),
                    (2, 'Kelaniya',50),
                    (3, 'Kotahena',50);";
            $db->pdo->exec($SQL);
        }

        // Add users data
        $checkColumnSQL = "SELECT * FROM `users`;";
$result = $db->pdo->query($checkColumnSQL)->fetch();

if (!$result) {
    // Prepare the user data
    $users = [
        ['admin@gmail.com', 'Nadun', 'Madusanka', 1, 'admin','+94764659122', 1, '/Photo/Staff/admin1.jpg', 'admin123'],
        ['customer@gmail.com', 'Ranuga', 'Lekawasam', 0, 'customer','+94764659123', 1, 'none', 'customer123'],
        ['steward@gmail.com', 'Mahesh', 'Kumara', 0, 'steward','+94764659124', 1, '/Photo/Staff/steward.jpg', 'steward123'],
        ['manager@gmail.com', 'Thirani', 'Athukorala', 0, 'manager','+94764659125', 1, '/Photo/Staff/manager3.jpg', 'manager123'],
        ['chef@gmail.com', 'Eraji', 'Thenuwara', 0, 'chef','+94764659126', 1, '/Photo/Staff/chef1.jpg', 'chef123'],
    ];

    // Prepare SQL
    $stmt = $db->pdo->prepare("INSERT INTO users (email, firstname, lastname, status, position, mobile_number, branch_id, photo, password, confirmPassword) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($users as $user) {
        list($email, $first, $last, $status, $position, $mobile, $branch, $photo, $plainPassword) = $user;
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $stmt->execute([$email, $first, $last, $status, $position, $mobile, $branch, $photo, $hashedPassword, $hashedPassword]);
    }
}



        // Add meals data
        $checkColumnSQL = "SELECT * FROM `meals`;";
        $result = $db->pdo->query($checkColumnSQL)->fetch();
        if (!$result) {
            $SQL = "INSERT INTO meals (meal_name, meal_price, meal_description, meal_photo) VALUES
                    ('Egg Kottu', 500.00, 2, '/Photo/Menu/1.jpg'),

                    ('Sea Food Kottu', 1200.00, 2, '/Photo/Menu/2.jpg'),

                    ('Chicken Kottu', 1200.00, 3, '/Photo/Menu/5.jpg'),

                    ('Sea Food Kottu', 1000.00, 4, '/Photo/Menu/24.jpg'),

                    ('String Hopper Kottu', 850.00, 5, '/Photo/Menu/27.jpg'),

                    ('Chicken Fried Rice', 900.00,6, '/Photo/Menu/26.jpg'),

                    ('Chilli Chicken Pasta', 1350.00, 7, '/Photo/Menu/25.jpg'),

                    ('Cheese Omelette', 500.00,8, '/Photo/Menu/3.jpg'),

                    ('Chilli Chicken', 1000.00, 9, '/Photo/Menu/6.jpg'),

                    ('Chocolate Roti', 500.00, 10, '/Photo/Menu/16.jpg'),

                    ('Chicken Parata', 950.00, 11, '/Photo/Menu/29.jpg'),

                    ('Devilled Chicken Kottu', 1200.00, 12, '/Photo/Menu/21.jpg'),

                    ('Blue Mojito', 700.00, 13, '/Photo/Menu/20.jpg'),

                    ('Chocolate Milkshake', 700.00, 14, '/Photo/Menu/9.jpg'),

                    ('Orange Mojito', 650.00, 14, '/Photo/Menu/17.jpg');";
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
                    (15, 3, 1), (12, 3, 1), (13, 3, 1), (14, 3, 1);";
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