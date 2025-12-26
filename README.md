# 📰 CMS Portal Berita

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![AdminLTE](https://img.shields.io/badge/AdminLTE-3.x-3C8DBC?style=for-the-badge)

Sistem Manajemen Konten (CMS) untuk Portal Berita berbasis Laravel 10 dengan AdminLTE 3 sebagai template admin panel. Project ini menyediakan fitur lengkap untuk mengelola artikel berita dengan antarmuka yang modern dan responsif.

## ✨ Fitur Utama

### 🔐 Authentication
- Login & Register dengan Laravel Breeze
- Role-based access (Admin/Visitor)
- Session management

### 📝 Manajemen Artikel
- **CRUD Artikel Lengkap** (Create, Read, Update, Delete)
- **Rich Text Editor** menggunakan Summernote
- **Upload Gambar** dengan thumbnail otomatis
- **Kategori Artikel** (Berita, Politik, Olahraga, Teknologi, Hiburan)
- **Auto-generate Slug** dari judul artikel
- **Excerpt/Ringkasan** artikel

### 🎨 Front-end Website
- Homepage dengan daftar artikel terbaru
- Detail artikel dengan artikel terkait
- Pagination
- Responsive design dengan Bootstrap 5
- Image fallback untuk artikel tanpa gambar

### 📊 Dashboard Admin
- Statistik total artikel
- Artikel bulan ini & hari ini
- Total user
- Daftar artikel terbaru

## 🛠️ Tech Stack

- **Framework:** Laravel 10.x
- **PHP:** 8.1+
- **Database:** MySQL 8.0
- **Admin Template:** AdminLTE 3.x
- **Authentication:** Laravel Breeze
- **Frontend:** Bootstrap 5
- **Text Editor:** Summernote

## 📋 Requirements

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk asset compilation)
- PHP Extensions:
  - PDO
  - Mbstring
  - OpenSSL
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - MySQL/PDO_MySQL

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/cms-portal-berita.git
cd cms-portal-berita
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
npm run build
```

### 3. Konfigurasi Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=raminten073
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Import Database

```bash
# Buat database terlebih dahulu
mysql -u root -p -e "CREATE DATABASE raminten073;"

# Import database
mysql -u root -p raminten073 < database/raminten073.sql
```

**Atau menggunakan migration:**

```bash
php artisan migrate
```

### 6. Setup Storage & Permissions

```bash
# Buat folder storage untuk upload gambar
mkdir -p public/storage/images

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache public/storage

# Jika menggunakan web server (Apache/Nginx)
sudo chown -R www-data:www-data storage bootstrap/cache public/storage
```

### 7. Install AdminLTE (Jika Belum Ada)

Download AdminLTE 3.x dari [GitHub](https://github.com/ColorlibHQ/AdminLTE/releases) dan extract ke folder `public/adminlte`

```bash
cd public
wget https://github.com/ColorlibHQ/AdminLTE/archive/refs/tags/v3.2.0.zip
unzip v3.2.0.zip
mv AdminLTE-3.2.0 adminlte
rm v3.2.0.zip
```

### 8. Clear Cache & Optimize

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

### 9. Jalankan Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 👤 Default User

Setelah import database, gunakan kredensial berikut untuk login:

```
Email: asikminten@gmail.com
Password: (sesuai password yang Anda buat)
```

**Atau buat user baru:**

```bash
php artisan tinker
```

Kemudian jalankan:

```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);
```

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/
│   │   ├── PostController.php        # CRUD Artikel
│   │   └── WebsiteController.php     # Frontend Website
│   └── Models/
│       └── Post.php                   # Model Artikel
│
├── database/
│   ├── migrations/                    # Database migrations
│   └── raminten073.sql               # Database dump
│
├── public/
│   ├── adminlte/                     # AdminLTE template
│   └── storage/images/               # Upload gambar artikel
│
├── resources/views/
│   ├── layouts/
│   │   └── administrator.blade.php   # Layout admin
│   ├── administrator/
│   │   ├── dashboard.blade.php       # Dashboard admin
│   │   └── posts/
│   │       ├── index.blade.php       # List artikel
│   │       ├── create.blade.php      # Form tambah artikel
│   │       └── edit.blade.php        # Form edit artikel
│   └── website/
│       ├── index.blade.php           # Homepage
│       └── detail.blade.php          # Detail artikel
│
└── routes/
    └── web.php                        # Route definitions
```

## 🎯 Fitur Route

### Public Routes
```
GET  /                          # Homepage
GET  /artikel/{slug}           # Detail artikel
```

### Admin Routes (Auth Required)
```
GET  /admin/dashboard          # Dashboard
GET  /admin/posts              # List artikel
GET  /admin/posts/create       # Form tambah artikel
POST /admin/posts              # Simpan artikel baru
GET  /admin/posts/{id}/edit    # Form edit artikel
PUT  /admin/posts/{id}         # Update artikel
DELETE /admin/posts/{id}       # Hapus artikel
```

## 📸 Screenshots

### Homepage
![Homepage](docs/screenshots/homepage.png)

### Admin Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Artikel Management
![Articles](docs/screenshots/articles.png)

### Form Editor
![Editor](docs/screenshots/editor.png)

## 🔧 Troubleshooting

### Error: "could not find driver"

```bash
# Install PHP MySQL extension
sudo apt install php-mysql php-pdo

# Restart PHP service
sudo systemctl restart php-fpm
```

### Error: Permission denied saat upload

```bash
chmod -R 775 public/storage
sudo chown -R www-data:www-data public/storage
```

### Error: View not found

```bash
php artisan view:clear
php artisan cache:clear
```

### Error: Route not found

```bash
php artisan route:clear
php artisan route:cache
```

## 🚀 Deployment (Production)

### 1. Optimize Aplikasi

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 2. Set Environment

Ubah di file `.env`:

```env
APP_ENV=production
APP_DEBUG=false
```

### 3. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🤝 Contributing

Kontribusi selalu diterima! Silakan buat pull request atau buka issue untuk bug report dan feature request.

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Project ini menggunakan lisensi [MIT License](LICENSE).

## 👨‍💻 Author

**raminten073**
- GitHub: [@raminten073](https://github.com/raminten073)
- Email: asikminten@gmail.com

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [AdminLTE](https://adminlte.io) - Admin Dashboard Template
- [Summernote](https://summernote.org) - WYSIWYG Editor
- [Bootstrap](https://getbootstrap.com) - CSS Framework

## 📞 Support

Jika Anda menemukan bug atau memiliki pertanyaan, silakan buka [issue](https://github.com/username/cms-portal-berita/issues) di GitHub.

---

⭐ Jangan lupa berikan star jika project ini bermanfaat!

**Made with ❤️ using Laravel 10**
