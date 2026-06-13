# Premium Custom Streetwear Website

A complete, pixel-perfect clone of the Viper Framer template built with Core PHP 8.2 OOP, MySQL with PDO, Bootstrap 5, and a custom MVC architecture.

## ✨ Features

- **Complete Single-Page Multi-Section Design** with 13 sections
- **Custom MVC Architecture** (Router → Controller → Model → View)
- **Security First**: CSRF protection, XSS filtering, bcrypt password hashing, prepared statements
- **Responsive Design**: Mobile-first approach with Bootstrap 5
- **Pure CSS Animations**: No external animation libraries
- **Dynamic Content**: Database-driven projects, testimonials, blog posts, services, and pricing
- **AJAX Contact Form**: No page reload on form submission

## 🛠 Tech Stack

- **Backend**: Core PHP 8.2, OOP, PDO + MySQL
- **Frontend**: HTML5, CSS3, Bootstrap 5.3, Vanilla JavaScript
- **Database**: MySQL 8.0+
- **Font**: Inter (Google Fonts)
- **Security**: CSRF tokens, XSS filtering, bcrypt, prepared statements

## 📦 Installation

### 1. Clone or Download
```bash
cd /var/www/html
# Or your web server's document root
```

### 2. Configure Database
Edit `config/database.php`:
```php
private $host = 'localhost';
private $db_name = 'streetwear_db';
private $username = 'root';
private $password = '';
```

### 3. Import Database
```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

### 4. Configure Web Server

**Apache** (`.htaccess` included):
- Enable `mod_rewrite`
- Set `AllowOverride All`

**Nginx**:
```nginx
location / {
    try_files $uri $uri/ /index.php?url=$uri&$args;
}
```

### 5. Set Base URL
Edit `config/app.php`:
```php
define('BASE_URL', 'http://localhost');
```

### 6. Access
Visit `http://localhost`

## 📁 Project Structure
```
/
├── app/Controllers/     # Application controllers
├── app/Models/          # Database models
├── config/              # Configuration files
├── core/                # Core MVC classes
├── database/            # Schema and seed files
├── public/css/          # Stylesheets
├── public/js/           # JavaScript files
├── views/               # View templates
├── .htaccess            # Apache rewrite rules
└── index.php            # Entry point
```

## 🗄 Database Tables
- `projects` - Portfolio items
- `testimonials` - Client reviews
- `blog_posts` - Blog articles
- `services` - Service offerings
- `pricing_plans` - Pricing tiers
- `contacts` - Form submissions
- `admin_users` - Admin authentication

## 🔐 Default Admin
- Username: `admin`
- Password: `admin123`

⚠️ **Change immediately in production!**

## 🎨 Customization

### Colors
Edit `public/css/style.css`:
```css
:root {
    --color-bg: #000000;
    --color-surface: #0d0d0d;
    --color-border: #1a1a1a;
    --color-white: #ffffff;
}
```

## 🔒 Security Features
- CSRF token validation
- PDO prepared statements
- XSS output escaping
- Bcrypt password hashing
- Session security

## ✅ Production Checklist
- [ ] Change database credentials
- [ ] Update BASE_URL
- [ ] Change admin password
- [ ] Enable HTTPS
- [ ] Optimize images
- [ ] Set up backups

## 📄 License
Proprietary - Premium Custom Streetwear © 2025

---
**Built with ❤️ by the Premium Custom Streetwear Team**
