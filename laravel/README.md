# Para Gotra Santana Dalem Tarukan (PGSDT)

Portal resmi Para Gotra Santana Dalem Tarukan - Sistem manajemen keanggotaan dan informasi untuk memperkuat persaudaraan dan melestarikan warisan leluhur Bali.

![Laravel](https://img.shields.io/badge/Laravel-13.x-red)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 🌟 Fitur Utama

### Untuk Member
- ✅ **Registrasi & Verifikasi Email** - Pendaftaran member dengan verifikasi email otomatis
- 👤 **Profil Digital** - Manajemen profil lengkap dengan foto dan identitas digital
- 📰 **Berita & Artikel** - Akses informasi terkini tentang kegiatan organisasi
- 📅 **Event Management** - Lihat dan daftar ke event/kegiatan yang akan datang
- 🔔 **Notifikasi Email** - Pemberitahuan otomatis untuk status keanggotaan dan event
- 🏛️ **Heritage** - Informasi tentang warisan budaya dan sejarah

### Untuk Admin
- 📊 **Dashboard Analytics** - Statistik member, event, dan aktivitas
- 👥 **Manajemen Member** - Verifikasi, edit, dan kelola data anggota
- 📝 **Manajemen Konten** - CRUD untuk berita dan artikel
- 🎯 **Manajemen Event** - Buat dan kelola event dengan sistem kuota
- 📋 **Registrasi Event** - Kelola pendaftaran peserta event
- 📤 **Export Data** - Export data member ke CSV
- 🗑️ **Soft Delete** - Data terhapus dapat dipulihkan

## 🚀 Teknologi

- **Framework**: Laravel 13.x
- **PHP**: 8.3+
- **Database**: MySQL
- **Frontend**: Tailwind CSS 4.0, Alpine.js
- **Build Tool**: Vite
- **Email**: SMTP (Gmail/Custom)
- **Cache**: Database/Redis
- **Queue**: Database

## 📋 Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL 5.7+ atau MariaDB 10.3+
- Web Server (Apache/Nginx)

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd Profile
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=PGSDT
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Konfigurasi Email
Edit file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pgsdtpusat1969@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="pgsdtpusat1969@gmail.com"
MAIL_FROM_NAME="PGSDT"
```

**Catatan**: Untuk Gmail, gunakan [App Password](https://support.google.com/accounts/answer/185833)

### 6. Migrasi Database
```bash
php artisan migrate
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
npm run build
```

### 9. Jalankan Development Server
```bash
composer run dev
```

Atau jalankan secara terpisah:
```bash
php artisan serve
php artisan queue:work
npm run dev
```

## 👤 Membuat Admin Pertama

Gunakan Tinker untuk membuat user admin:
```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin PGSDT',
    'email' => 'admin@pgsdt.org',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'nik' => '1234567890123456',
    'register_number' => 'PGSDT-ADMIN-001',
    'kabupaten' => 'Bangli',
    'member_status' => 'active',
    'email_verified_at' => now(),
]);
```

## 📁 Struktur Folder Penting

```
app/
├── Http/Controllers/       # Controllers
│   ├── Admin/             # Admin controllers
│   ├── AuthController.php
│   └── ...
├── Models/                # Eloquent models
├── Notifications/         # Email notifications
├── Observers/            # Model observers
└── Helpers/              # Helper classes

resources/
├── views/
│   ├── admin/           # Admin views
│   ├── auth/            # Authentication views
│   ├── pages/           # Public pages
│   └── layouts/         # Layout templates
└── css/                 # Stylesheets

database/
├── migrations/          # Database migrations
└── seeders/            # Database seeders

public/
├── assets/             # Images & static files
└── storage/            # Symlink to storage
```

## 🔐 Keamanan

- ✅ CSRF Protection pada semua form
- ✅ Rate Limiting untuk login & registrasi
- ✅ Email Verification untuk member baru
- ✅ Validasi NIK 16 digit
- ✅ Image upload validation & size limit
- ✅ Soft Delete untuk data penting
- ✅ Password hashing dengan bcrypt
- ✅ SQL Injection protection (Eloquent ORM)

## 📧 Email Notifications

Sistem mengirim email otomatis untuk:
- Member baru mendaftar (ke admin)
- Member diverifikasi (ke member)
- Pendaftaran event diterima
- Status pendaftaran event berubah

## 🎨 Customization

### Mengubah Warna Tema
Edit `resources/css/app.css`:
```css
:root {
  --primary-dark: #0a1f1c;
  --accent-gold: #d4af37;
  --text-light: #f5f5f5;
}
```

### Mengubah Logo
Ganti file di `public/assets/Logo.png`

## 🚀 Deployment ke Production

### 1. Update Environment
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Optimize
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Setup Queue Worker
Tambahkan ke crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Setup supervisor untuk queue:
```ini
[program:pgsdt-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-project/storage/logs/worker.log
```

### 4. Setup Backup
Install package backup:
```bash
composer require spatie/laravel-backup
```

## 🐛 Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Error: Storage link
```bash
php artisan storage:link
```

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Cache Issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 📞 Kontak

**Para Gotra Santana Dalem Tarukan**
- 📍 Sekretariat: Pura Pedharman Pusat Ida Bhatara Dalem Tarukan, Pulasari, Peninjoan, Kec. Tembuku, Kab. Bangli
- ✉️ Email: pgsdtpusat1969@gmail.com
- 📞 Telepon: 081283144560, 08123919488

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Credits

Developed with ❤️ for Para Gotra Santana Dalem Tarukan

**Om Swastyastu**
