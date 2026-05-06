# 🚀 Panduan Deployment PGSDT

Panduan lengkap untuk deploy aplikasi PGSDT ke production server.

## 📋 Checklist Pre-Deployment

- [ ] Server dengan PHP 8.3+, MySQL, dan Composer terinstall
- [ ] Domain sudah disiapkan dan DNS dikonfigurasi
- [ ] SSL Certificate (Let's Encrypt/Cloudflare)
- [ ] Email SMTP credentials (Gmail App Password)
- [ ] Backup database development (jika ada data penting)

## 🖥️ Server Requirements

### Minimum Specifications
- **CPU**: 2 cores
- **RAM**: 2GB
- **Storage**: 20GB SSD
- **OS**: Ubuntu 20.04+ / CentOS 8+

### Software Requirements
```bash
- PHP 8.3+
- MySQL 8.0+ / MariaDB 10.6+
- Nginx / Apache
- Composer 2.x
- Node.js 18+ & NPM
- Supervisor (untuk queue worker)
- Redis (optional, untuk cache & queue)
```

## 🔧 Setup Server

### 1. Install PHP & Extensions
```bash
sudo apt update
sudo apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring \
    php8.3-xml php8.3-bcmath php8.3-curl php8.3-zip php8.3-gd \
    php8.3-intl php8.3-redis
```

### 2. Install MySQL
```bash
sudo apt install mysql-server
sudo mysql_secure_installation
```

Buat database:
```sql
CREATE DATABASE pgsdt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'pgsdt_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON pgsdt.* TO 'pgsdt_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 4. Install Node.js & NPM
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 5. Install Nginx
```bash
sudo apt install nginx
```

## 📦 Deploy Aplikasi

### 1. Clone Repository
```bash
cd /var/www
sudo git clone <repository-url> pgsdt
cd pgsdt
sudo chown -R www-data:www-data /var/www/pgsdt
```

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="PGSDT"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgsdt
DB_USERNAME=pgsdt_user
DB_PASSWORD=strong_password_here

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pgsdtpusat1969@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="pgsdtpusat1969@gmail.com"
MAIL_FROM_NAME="PGSDT"

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 4. Setup Database
```bash
php artisan migrate --force
php artisan db:seed --class=AdminSeeder
php artisan storage:link
```

### 5. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/pgsdt
sudo chmod -R 755 /var/www/pgsdt
sudo chmod -R 775 /var/www/pgsdt/storage
sudo chmod -R 775 /var/www/pgsdt/bootstrap/cache
```

### 6. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🌐 Konfigurasi Nginx

Buat file `/etc/nginx/sites-available/pgsdt`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/pgsdt/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;

    charset utf-8;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/pgsdt /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## 🔒 Setup SSL dengan Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Auto-renewal:
```bash
sudo certbot renew --dry-run
```

## ⚙️ Setup Queue Worker dengan Supervisor

Buat file `/etc/supervisor/conf.d/pgsdt-worker.conf`:

```ini
[program:pgsdt-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/pgsdt/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/pgsdt/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start pgsdt-worker:*
```

## 📅 Setup Cron Jobs

Edit crontab:
```bash
sudo crontab -e -u www-data
```

Tambahkan:
```cron
* * * * * cd /var/www/pgsdt && php artisan schedule:run >> /dev/null 2>&1
```

## 🔄 Update Aplikasi

Script untuk update:
```bash
#!/bin/bash
cd /var/www/pgsdt

# Maintenance mode
php artisan down

# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear & cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Restart services
sudo supervisorctl restart pgsdt-worker:*

# Exit maintenance mode
php artisan up

echo "Deployment completed!"
```

## 📊 Monitoring & Logging

### View Logs
```bash
tail -f /var/www/pgsdt/storage/logs/laravel.log
tail -f /var/www/pgsdt/storage/logs/worker.log
```

### Monitor Queue
```bash
php artisan queue:monitor redis
```

### Check Worker Status
```bash
sudo supervisorctl status pgsdt-worker:*
```

## 🔐 Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] Strong database password
- [ ] SSL/HTTPS enabled
- [ ] Firewall configured (UFW)
- [ ] Regular backups setup
- [ ] File permissions correct (755/775)
- [ ] `.env` file tidak ter-commit ke git
- [ ] Rate limiting enabled
- [ ] CSRF protection active
- [ ] SQL injection protection (Eloquent)

## 💾 Backup Strategy

### Database Backup
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u pgsdt_user -p pgsdt > /backups/pgsdt_$DATE.sql
gzip /backups/pgsdt_$DATE.sql

# Keep only last 7 days
find /backups -name "pgsdt_*.sql.gz" -mtime +7 -delete
```

### Files Backup
```bash
tar -czf /backups/pgsdt_files_$(date +%Y%m%d).tar.gz \
    /var/www/pgsdt/storage/app/public \
    /var/www/pgsdt/.env
```

Setup cron untuk backup otomatis:
```cron
0 2 * * * /path/to/backup-script.sh
```

## 🆘 Troubleshooting

### 500 Internal Server Error
```bash
php artisan config:clear
php artisan cache:clear
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Queue Not Processing
```bash
sudo supervisorctl restart pgsdt-worker:*
php artisan queue:restart
```

### Email Not Sending
- Cek SMTP credentials di `.env`
- Pastikan port 587 tidak diblok firewall
- Test dengan: `php artisan tinker` → `Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });`

### High Memory Usage
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

## 📞 Support

Jika ada masalah saat deployment, hubungi:
- Email: pgsdtpusat1969@gmail.com
- WhatsApp: 081283144560

---

**Om Swastyastu** 🙏
