# 🍛 Kottu Labs

**Kottu Labs** is a full-featured restaurant management system tailored for multi-branch operations. It streamlines workflows such as reservations, order management, payment processing, staff coordination, and reporting. The system supports multiple user roles with role-based access control and real-time order and reservation tracking.

---

## 🔍 Overview

Kottu Labs is a web-based platform built using **PHP** following the **MVC (Model-View-Controller)** architectural pattern. It caters to customers, chefs, stewards, managers, and administrators, providing each with customized functionalities to ensure efficient restaurant management.

---

## 🚀 Features

### 👥 For Customers
- Register and log in securely
- Browse menus and branch-specific offers
- Make table reservations (dine-in or takeaway)
- Receive PIN-based reservation confirmation
- Place and track orders
- Make secure online payments via **PayHere**
- Provide reviews and feedback

### 🍳 For Staff
- **Chef**: View and process kitchen orders, mark meals as prepared, manage meal availability
- **Steward**: Manage order deliveries, customer seating, and handle payments

### 🧑‍💼 For Managers
- Monitor branch operations
- Manage branch-specific menus and staff
- View and manage reservations
- Access branch-level analytics and reports

### 🛠️ For Administrators
- System-wide analytics and dashboards
- Manage all staff and branches
- Oversee menu and promotional offers
- Access customer feedback and performance reports

---

## 🛠️ Technical Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL / MariaDB
- **Dependency Management**: Composer
- **Environment Management**: Dotenv
- **Payment Integration**: [PayHere](https://www.payhere.lk/)

---

## 🏗️ System Architecture

Kottu Labs follows an MVC structure:
- **Models**: Handle database logic and schema (e.g., `users`, `orders`, `meals`, etc.)
- **Views**: UI templates for all user roles
- **Controllers**: Process user input, business logic, and route handling

---

## 🗂️ Directory Structure

```
├── controllers/         # Application logic
├── core/                # Base classes and framework logic
├── migrations/          # DB schema and seeders
├── models/              # Database models
├── public/              # Entry point and assets (CSS/JS)
├── views/               # Blade-style templates
├── .env                 # Environment config
├── composer.json        # Dependency file
└── index.php            # Front controller
```

---

## 🧰 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/NadunMN/Kottu-Labs.git
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment variables**
   Create a `.env` file in the root directory:
   ```env
   DB_DSN=mysql:host=localhost;port=3306;dbname=kottu_labs
   DB_USER=root
   DB_PASSWORD=your_password
   ```

4. **Run database migrations**
   - Import the SQL schema from the `migrations/` folder.

5. **Set up your web server**
   - Point your Apache/Nginx server root to the `public/` directory.

6. **Optional:** Configure mail settings for reservation notifications.

---

## 🧑‍💻 Usage Guide

### 🔐 Authentication Routes
| Route        | Description           |
|--------------|-----------------------|
| `/login`     | User login            |
| `/register`  | New user registration |
| `/logout`    | Logout current user   |

### 👤 User Routes
| Route           | Description               |
|-----------------|---------------------------|
| `/profile`      | Dashboard (based on role) |
| `/myaccount`    | Profile settings          |

### 🍽️ Menu & Offers
| Route      | Description             |
|------------|-------------------------|
| `/menu`    | View all meals          |
| `/offer`   | View special promotions |

### 🧾 Orders & Payments
| Route         | Description               |
|---------------|---------------------------|
| `/cart`       | Shopping cart             |
| `/payment`    | Payment via PayHere/cash  |

### 📅 Reservations
| Route                | Description                  |
|----------------------|------------------------------|
| `/dinein`            | Make dine-in reservation     |
| `/confirmreservation`| PIN verification for booking |

---

## 📡 API Endpoints

### Reservation
- `GET /reservation/otp`: Verify reservation PIN
- `POST /reservation/add`: Make a new reservation
- `POST /reservation/addtable`: Assign table to reservation

### Orders
- `POST /cart/add`: Add item to cart
- `GET /getMealscart`: View cart
- `POST /removeFromCart`: Remove item
- `POST /updateCartQuantity`: Change quantity
- `POST /clearCart`: Clear entire cart

### Payments
- `POST /payment/confirm`: Confirm payment
- `GET /payment/getCashPaymentDetails`: Cash details for verification

---

## 🔒 Security Features

- Password hashing using strong algorithms
- Session management for authentication
- Input validation to prevent SQL injection/XSS
- Graceful error handling without revealing internals

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push the branch to your fork
5. Open a Pull Request

---

## 📄 License

_This project is licensed under [Your License Here]_

---

## 📬 Contact

For issues, feature requests, or support:  
**Email**: [your.email@example.com]  
**GitHub**: [https://github.com/NadunMN/Kottu-Labs](https://github.com/NadunMN/Kottu-Labs)

---

## 🙏 Acknowledgements

Thanks to all contributors and libraries that made this system possible.

---

> _“From the kitchen to the cloud – Kottu Labs powers your restaurant with smart tech!”_