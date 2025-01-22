# ClientsManager 📊

A robust PHP-based client management system with CRUD operations and pagination functionality.

## 🚀 Features

- Complete CRUD operations for client management
- Paginated client list view
- Detailed client profiles
- MVC architecture for clean code organization
- Secure database operations
- Responsive user interface

## 📋 Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (for dependency management)

## 🛠️ Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/ClientsManager.git
```

2. Navigate to the project directory:

```bash
cd ClientsManager
```

3. Configure your database connection in `config/configDB.php`

4. Import the database schema:

```bash
mysql -u your_username -p your_database < Clientes.sql
```

## 📁 Project Structure

```
ClientsManager/
├── app/
│   ├── config/
│   │   └── configDB.php
│   ├── controllers/
│   │   ├── crusclients.php
│   │   └── util.php
│   ├── models/
│   │   ├── AccesoDatosPDO.php
│   │   └── Cliente.php
│   └── views/
│       ├── detalles.php
│       ├── formulario.php
│       ├── list.php
│       └── principal.php
├── web/
│   ├── css/
│   │   └── default.css
│   └── js/
│       └── funciones.js
└── .htaccess
```

## 🔧 Configuration

1. Update database credentials in `config/configDB.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

## 💻 Usage

1. Access the application through your web browser
2. Use the navigation menu to:
   - View client list with pagination
   - Add new clients
   - Edit existing client information
   - View detailed client profiles
   - Delete clients

## 🔐 Security Features

- PDO prepared statements for database operations
- Input validation and sanitization
- Secure password handling
- Access control implementation

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## ✨ Acknowledgments

- Built with PHP and MySQL
- Uses MVC architecture pattern
- Implements responsive design principles
- Features secure database operations
