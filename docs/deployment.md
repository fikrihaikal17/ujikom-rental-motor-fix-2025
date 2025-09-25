# Deployment Guide - RideNow 🚀

## 📋 Table of Contents

1. [Overview](#overview)
2. [System Requirements](#system-requirements)
3. [Pre-Deployment Checklist](#pre-deployment-checklist)
4. [Local Development Setup](#local-development-setup)
5. [Production Deployment](#production-deployment)
6. [Environment Configuration](#environment-configuration)
7. [Security Hardening](#security-hardening)
8. [Monitoring & Maintenance](#monitoring--maintenance)
9. [Troubleshooting](#troubleshooting)

## 🎯 Overview

Panduan lengkap untuk deploy RideNow dari development ke production environment. Mencakup setup server, konfigurasi database, security hardening, dan monitoring.

### Deployment Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Load Balancer │    │   Web Server    │    │    Database     │
│     (Nginx)     │◄──►│   (PHP-FPM)     │◄──►│     (MySQL)     │
│                 │    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│      CDN        │    │   File Storage  │    │     Cache       │
│   (CloudFlare)  │    │     (S3/Local)  │    │     (Redis)     │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

---

## 💻 System Requirements

### Minimum Requirements (Production)

```yaml
Server Specifications:
    - CPU: 2 cores (2.4 GHz+)
    - RAM: 4 GB
    - Storage: 50 GB SSD
    - Bandwidth: 100 Mbps
    - OS: Ubuntu 22.04 LTS / CentOS 8+

Software Stack:
    - PHP: 8.2+ (with extensions)
    - Web Server: Nginx 1.20+ / Apache 2.4+
    - Database: MySQL 8.0+ / PostgreSQL 13+
    - Process Manager: Supervisor
    - Cache: Redis 6.0+ (optional but recommended)
    - SSL: Let's Encrypt / Commercial Certificate
```

### PHP Extensions Required

```bash
# Essential PHP Extensions
php8.2-fpm
php8.2-mysql
php8.2-redis
php8.2-xml
php8.2-curl
php8.2-gd
php8.2-mbstring
php8.2-zip
php8.2-intl
php8.2-bcmath
php8.2-tokenizer
php8.2-json
php8.2-openssl
```

### Recommended Requirements (High Traffic)

```yaml
Server Specifications:
    - CPU: 4+ cores (3.0 GHz+)
    - RAM: 8+ GB
    - Storage: 100+ GB NVMe SSD
    - Bandwidth: 1 Gbps
    - CDN: CloudFlare / AWS CloudFront

Additional Services:
    - Load Balancer: Nginx / HAProxy
    - Cache: Redis Cluster
    - Search: Elasticsearch (optional)
    - Monitoring: New Relic / DataDog
    - Backup: Automated daily backups
```

---

## ✅ Pre-Deployment Checklist

### Code Preparation

```bash
# 1. Code Quality Checks
composer install --no-dev --optimize-autoloader
npm run production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Security Checks
php artisan key:generate
php artisan storage:link

# 3. Database Preparation
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder

# 4. Testing
php artisan test
vendor/bin/phpunit
```

### Environment Validation

```bash
# Check PHP version and extensions
php -v
php -m | grep -E "(mysql|redis|gd|curl|mbstring)"

# Check Composer dependencies
composer check-platform-reqs

# Validate Laravel configuration
php artisan about
php artisan config:clear
php artisan config:cache
```

### Security Preparation

```bash
# Generate application key
php artisan key:generate --force

# Set proper file permissions
sudo chown -R www-data:www-data /var/www/ridenow
sudo chmod -R 755 /var/www/ridenow
sudo chmod -R 775 /var/www/ridenow/storage
sudo chmod -R 775 /var/www/ridenow/bootstrap/cache
```

---

## 🔧 Local Development Setup

### 1. Clone Repository

```bash
# Clone project
git clone https://github.com/your-username/ridenow.git
cd ridenow

# Install dependencies
composer install
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database
php artisan migrate
php artisan db:seed
```

### 2.1. Custom Console Commands

**Setup Rental Data Command**

```bash
# Setup complete rental system with realistic data
php artisan setup:rental-data

# This command will:
# - Create admin, owners, and renters
# - Generate 25 Gmail-based renter accounts
# - Create motors with tariff configurations
# - Generate 163 realistic rental transactions
# - Setup revenue sharing data
```

**Available Custom Commands:**

```bash
# List all available commands
php artisan list

# Custom commands available:
php artisan setup:rental-data    # Complete rental system setup
php artisan app:setup-rental-data # Alternative command name
```

### 3. Development Server

```bash
# Start Laravel development server
php artisan serve

# Start frontend development (if using Vite)
npm run dev

# Start queue worker (in separate terminal)
php artisan queue:work

# Access application
# URL: http://127.0.0.1:8000
```

### 4. Development Tools Setup

```bash
# Install development tools
composer require --dev laravel/telescope
php artisan telescope:install
php artisan migrate

# Debug bar (optional)
composer require --dev barryvdh/laravel-debugbar
php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"
```

---

## 🚀 Production Deployment

### 1. Server Setup (Ubuntu 22.04)

#### Install Required Software

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-redis php8.2-xml \
  php8.2-curl php8.2-gd php8.2-mbstring php8.2-zip php8.2-intl \
  php8.2-bcmath php8.2-tokenizer php8.2-json php8.2-openssl

# Install Nginx
sudo apt install -y nginx

# Install MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation

# Install Redis (optional)
sudo apt install -y redis-server

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js and npm
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

#### Configure MySQL Database

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE ridenow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'ridenow_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON ridenow.* TO 'ridenow_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Deploy Application

#### Upload Application Files

```bash
# Create application directory
sudo mkdir -p /var/www/ridenow
cd /var/www/ridenow

# Clone repository (or upload files)
sudo git clone https://github.com/your-username/ridenow.git .

# Set ownership
sudo chown -R www-data:www-data /var/www/ridenow
```

#### Install Dependencies

```bash
# Install PHP dependencies
sudo -u www-data composer install --no-dev --optimize-autoloader

# Install and build frontend assets
sudo -u www-data npm install
sudo -u www-data npm run production
```

#### Configure Environment

```bash
# Copy environment file
sudo cp .env.example .env
sudo chown www-data:www-data .env

# Edit environment file
sudo nano .env
```

**Production .env Configuration:**

```env
APP_NAME="RideNow"
APP_ENV=production
APP_KEY=base64:generated_key_here
APP_DEBUG=false
APP_TIMEZONE="Asia/Jakarta"
APP_URL=https://ridenow.com

LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ridenow
DB_USERNAME=ridenow_user
DB_PASSWORD=secure_password_here

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ridenow.com
MAIL_FROM_NAME="${APP_NAME}"

SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.ridenow.com
```

#### Initialize Application

```bash
# Generate application key
sudo -u www-data php artisan key:generate

# Create symbolic link for storage
sudo -u www-data php artisan storage:link

# Run migrations
sudo -u www-data php artisan migrate --force

# Seed production data
sudo -u www-data php artisan db:seed --class=ProductionSeeder

# Cache configurations
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
```

### 3. Configure Nginx

#### Create Nginx Virtual Host

```bash
sudo nano /etc/nginx/sites-available/ridenow
```

**Nginx Configuration:**

```nginx
server {
    listen 80;
    server_name ridenow.com www.ridenow.com;
    root /var/www/ridenow/public;
    index index.php index.html index.htm;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Static file caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        add_header Vary Accept-Encoding;
        access_log off;
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    location ~ /\.env {
        deny all;
        access_log off;
        log_not_found off;
    }

    # File upload limit
    client_max_body_size 20M;

    # Error and access logs
    access_log /var/log/nginx/ridenow_access.log;
    error_log /var/log/nginx/ridenow_error.log;
}
```

#### Enable Site and Restart Nginx

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/ridenow /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx

# Enable services
sudo systemctl enable nginx
sudo systemctl enable php8.2-fpm
sudo systemctl enable mysql
```

### 4. SSL Certificate Setup

#### Install Certbot (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d ridenow.com -d www.ridenow.com

# Verify auto-renewal
sudo certbot renew --dry-run

# Add auto-renewal to crontab
echo "0 12 * * * /usr/bin/certbot renew --quiet" | sudo crontab -
```

### 5. Configure Queue Worker

#### Create Supervisor Configuration

```bash
sudo nano /etc/supervisor/conf.d/ridenow-worker.conf
```

**Supervisor Configuration:**

```ini
[program:ridenow-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/ridenow/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/ridenow/storage/logs/worker.log
stopwaitsecs=3600
```

#### Start Supervisor

```bash
# Install supervisor
sudo apt install -y supervisor

# Update supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ridenow-worker:*

# Check status
sudo supervisorctl status
```

---

## 🔐 Security Hardening

### 1. Server Security

#### Firewall Configuration

```bash
# Install and configure UFW
sudo ufw enable
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw status
```

#### SSH Hardening

```bash
# Edit SSH configuration
sudo nano /etc/ssh/sshd_config

# Recommended settings:
# Port 2222 (change default port)
# PermitRootLogin no
# PasswordAuthentication no
# PubkeyAuthentication yes
# MaxAuthTries 3

# Restart SSH
sudo systemctl restart ssh
```

#### Automatic Security Updates

```bash
# Install unattended-upgrades
sudo apt install -y unattended-upgrades

# Configure automatic updates
sudo nano /etc/apt/apt.conf.d/50unattended-upgrades

# Enable automatic updates
sudo dpkg-reconfigure -plow unattended-upgrades
```

### 2. Application Security

#### File Permissions

```bash
# Set secure permissions
sudo chown -R www-data:www-data /var/www/ridenow
sudo chmod -R 755 /var/www/ridenow
sudo chmod -R 775 /var/www/ridenow/storage
sudo chmod -R 775 /var/www/ridenow/bootstrap/cache
sudo chmod 600 /var/www/ridenow/.env
```

#### Hide Sensitive Information

```bash
# Add to Nginx configuration
server_tokens off;

# Add to PHP-FPM configuration
expose_php = Off

# Laravel security headers (already in Nginx config above)
```

#### Database Security

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create limited user for application
# Remove test databases
# Disable remote root login
```

### 3. Monitoring & Logging

#### Log Rotation

```bash
# Configure log rotation
sudo nano /etc/logrotate.d/ridenow

# Log rotation configuration:
/var/www/ridenow/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    postrotate
        sudo systemctl reload php8.2-fpm
    endscript
}
```

#### Fail2Ban Setup

```bash
# Install Fail2Ban
sudo apt install -y fail2ban

# Configure for Nginx
sudo nano /etc/fail2ban/jail.local

# Configuration:
[nginx-http-auth]
enabled = true
port = http,https
logpath = /var/log/nginx/error.log

[nginx-noscript]
enabled = true
port = http,https
logpath = /var/log/nginx/access.log

# Restart Fail2Ban
sudo systemctl restart fail2ban
```

---

## 📊 Monitoring & Maintenance

### 1. Performance Monitoring

#### Install Monitoring Tools

```bash
# Install htop for system monitoring
sudo apt install -y htop iotop netstat-nat

# Install MySQL monitoring
sudo apt install -y mytop
```

#### Application Monitoring

```bash
# Laravel Telescope (production-safe)
composer require laravel/telescope
php artisan telescope:install
php artisan migrate

# Configure Telescope for production
# Set TELESCOPE_ENABLED=true in .env (only for admin access)
```

### 2. Backup Strategy

#### Database Backup Script

```bash
# Create backup script
sudo nano /usr/local/bin/backup-ridenow.sh

#!/bin/bash
# RideNow Database Backup Script

BACKUP_DIR="/var/backups/ridenow"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="ridenow"
DB_USER="ridenow_user"
DB_PASS="secure_password_here"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/db_backup_$DATE.sql

# Keep only last 30 days of backups
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +30 -delete

# Application files backup
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz -C /var/www ridenow

echo "Backup completed: $DATE"
```

#### Automated Backup Cron

```bash
# Make script executable
sudo chmod +x /usr/local/bin/backup-ridenow.sh

# Add to crontab
sudo crontab -e

# Add this line for daily backups at 2 AM
0 2 * * * /usr/local/bin/backup-ridenow.sh >> /var/log/ridenow-backup.log 2>&1
```

### 3. Health Checks

#### Application Health Check

```bash
# Create health check script
sudo nano /usr/local/bin/health-check-ridenow.sh

#!/bin/bash
# RideNow Health Check Script

APP_URL="https://ridenow.com"
STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" $APP_URL)

if [ $STATUS_CODE -eq 200 ]; then
    echo "$(date): Application is healthy (HTTP $STATUS_CODE)"
else
    echo "$(date): Application health check failed (HTTP $STATUS_CODE)" | mail -s "RideNow Alert" admin@ridenow.com
fi

# Check database connection
php /var/www/ridenow/artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection OK';"
```

#### Service Monitoring

```bash
# Check critical services
sudo systemctl is-active nginx
sudo systemctl is-active php8.2-fpm
sudo systemctl is-active mysql
sudo systemctl is-active redis-server
sudo supervisorctl status ridenow-worker:*
```

---

## 🔧 Troubleshooting

### Common Issues & Solutions

#### 1. Application Issues

**500 Internal Server Error**

```bash
# Check Laravel logs
tail -f /var/www/ridenow/storage/logs/laravel.log

# Check Nginx error logs
sudo tail -f /var/log/nginx/ridenow_error.log

# Common solutions:
sudo chown -R www-data:www-data /var/www/ridenow/storage
sudo chmod -R 775 /var/www/ridenow/storage
php artisan config:clear
php artisan cache:clear
```

**Database Connection Issues**

```bash
# Test database connection
php /var/www/ridenow/artisan tinker
> DB::connection()->getPdo();

# Check MySQL status
sudo systemctl status mysql
sudo mysql -u ridenow_user -p

# Fix permissions
GRANT ALL PRIVILEGES ON ridenow.* TO 'ridenow_user'@'localhost';
FLUSH PRIVILEGES;
```

#### 2. Performance Issues

**High Load Average**

```bash
# Check system resources
htop
iostat -x 1
df -h

# Check MySQL processes
sudo mysql -e "SHOW PROCESSLIST;"

# Optimize MySQL
sudo mysql -e "OPTIMIZE TABLE users, motors, penyewaans;"
```

**Memory Issues**

```bash
# Check memory usage
free -h
sudo ps aux --sort=-%mem | head

# Restart services if needed
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart ridenow-worker:*
```

#### 3. SSL/HTTPS Issues

**Certificate Renewal**

```bash
# Check certificate expiry
sudo certbot certificates

# Force renewal
sudo certbot renew --force-renewal

# Test renewal
sudo certbot renew --dry-run
```

---

## 📈 Scaling Considerations

### Horizontal Scaling

#### Load Balancer Setup

```nginx
# Nginx load balancer configuration
upstream ridenow_backend {
    server 192.168.1.10:80 weight=1;
    server 192.168.1.11:80 weight=1;
    server 192.168.1.12:80 weight=1;
}

server {
    listen 443 ssl;
    server_name ridenow.com;

    location / {
        proxy_pass http://ridenow_backend;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

#### Database Scaling

```yaml
# Master-Slave Configuration
Master Database:
    - All write operations
    - Primary data source

Slave Databases:
    - Read operations only
    - Real-time replication
    - Load distribution
```

### Performance Optimization

#### Caching Strategy

```bash
# Redis configuration for production
sudo nano /etc/redis/redis.conf

# Optimize for your memory
maxmemory 2gb
maxmemory-policy allkeys-lru

# Enable persistence
save 900 1
save 300 10
save 60 10000
```

#### CDN Integration

```javascript
// CloudFlare integration
// Update asset URLs to use CDN
// Configure cache headers
// Enable Brotli compression
```

---

**Deployment Guide v1.0**  
_Last Updated: September 23, 2025_  
_For RideNow Platform v1.0.0_
