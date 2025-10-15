# 🚀 HƯỚNG DẪN SETUP NHANH

## ⚠️ LƯU Ý

Project này được tạo với cấu trúc Laravel thủ công để demo giao diện.
Để chạy được đầy đủ, bạn cần có **Laravel đã cài đặt** trên máy.

---

## PHƯƠNG ÁN 1: CÀI ĐẶT LARAVEL ĐẦY ĐỦ (Khuyến nghị)

### Bước 1: Cài đặt PHP & Composer

#### Windows:
```bash
# Download XAMPP hoặc Laragon
# https://www.apachefriends.org/
# https://laragon.org/

# Cài Composer
# https://getcomposer.org/download/
```

#### Mac:
```bash
# Install Homebrew (nếu chưa có)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php

# Install Composer
brew install composer
```

#### Linux (Ubuntu/Debian):
```bash
# Install PHP
sudo apt update
sudo apt install php php-cli php-fpm php-mysql php-xml php-mbstring php-curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

### Bước 2: Tạo Laravel Project mới

Vì project hiện tại chỉ có structure, bạn có 2 cách:

#### Cách 1: Tạo mới và copy files vào

```bash
# Tạo Laravel project mới
composer create-project laravel/laravel dailong-wms

# Copy các file từ project này sang:
# - app/Http/Controllers/* → app/Http/Controllers/
# - resources/views/* → resources/views/
# - routes/web.php → routes/web.php
# - public/css/* → public/css/
# - public/js/* → public/js/
```

#### Cách 2: Cài dependencies vào project hiện tại

```bash
cd dailong-warehouse-laravel

# Khởi tạo composer.json nếu chưa có
composer init

# Require Laravel framework
composer require laravel/framework
composer require laravel/tinker

# Copy .env.example → .env
cp .env.example .env

# Generate app key
php artisan key:generate
```

---

### Bước 3: Cấu hình Database

```bash
# 1. Tạo database
mysql -u root -p
CREATE DATABASE dailong_warehouse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# 2. Cập nhật .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dailong_warehouse
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### Bước 4: Chạy Migrations

```bash
# Tạo migrations (hoặc sử dụng có sẵn nếu có)
php artisan migrate

# Nếu chưa có migrations, tạm thời comment DB queries trong controllers
```

---

### Bước 5: Chạy Server

```bash
php artisan serve
```

Truy cập: **http://localhost:8000**

---

## PHƯƠNG ÁN 2: XEM GIAO DIỆN NHANH (Không cần Laravel)

Nếu bạn chỉ muốn xem giao diện mà không setup Laravel:

```bash
# Mở file HTML gốc trong browser
cd /workspace
open warehouse-management-dailong.html

# Hoặc
firefox warehouse-management-dailong.html
```

File này chứa **toàn bộ giao diện** với demo data static.

---

## PHƯƠNG ÁN 3: SỬ DỤNG DOCKER (Advanced)

```bash
# Tạo Dockerfile
cat > Dockerfile <<'EOF'
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EOF

# Build & Run
docker build -t dailong-wms .
docker run -p 8000:8000 dailong-wms
```

---

## 📋 CHECKLIST SETUP

- [ ] PHP >= 8.1 đã cài đặt
- [ ] Composer đã cài đặt
- [ ] MySQL/MariaDB đã cài đặt
- [ ] Đã tạo database `dailong_warehouse`
- [ ] Đã copy .env.example → .env
- [ ] Đã cấu hình database trong .env
- [ ] Đã chạy `composer install`
- [ ] Đã chạy `php artisan key:generate`
- [ ] Đã chạy `php artisan migrate` (nếu có)
- [ ] Server đã chạy thành công

---

## 🐛 TROUBLESHOOTING

### Lỗi: "composer: command not found"
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Lỗi: "php: command not found"
```bash
# Install PHP
# Windows: Cài XAMPP
# Mac: brew install php
# Linux: sudo apt install php
```

### Lỗi: "SQLSTATE[HY000] [1045] Access denied"
```bash
# Kiểm tra lại thông tin database trong .env
# Đảm bảo MySQL đã chạy
```

### Lỗi: "Class 'Illuminate\...' not found"
```bash
# Chạy lại composer install
composer install
composer dump-autoload
```

### Lỗi: "No application encryption key has been specified"
```bash
php artisan key:generate
```

---

## 📚 TÀI LIỆU THAM KHẢO

- [Laravel Installation](https://laravel.com/docs/10.x/installation)
- [Composer Installation](https://getcomposer.org/doc/00-intro.md)
- [PHP Installation](https://www.php.net/manual/en/install.php)
- [MySQL Installation](https://dev.mysql.com/doc/refman/8.0/en/installing.html)

---

## 💡 MẸO NHANH

### Chạy với PHP Built-in Server (Không cần Composer)

```bash
cd dailong-warehouse-laravel
php -S localhost:8000 -t public

# Truy cập: http://localhost:8000
```

**⚠️ Lưu ý:** Cách này sẽ không có routing Laravel, chỉ xem được static files.

### Xem Log nếu có lỗi

```bash
tail -f storage/logs/laravel.log
```

---

## 🎯 DEMO DATA

Controllers đã có **mock data** sẵn, không cần database để xem giao diện:

- `DashboardController` → Mock stats & activities
- `InventoryController` → Mock products list
- `ReceiptController` → Mock receipts
- `QCController` → Mock QC queue

Bạn có thể chạy ngay để xem UI!

---

## ✅ KIỂM TRA

Sau khi setup, kiểm tra các routes:

```bash
# Dashboard
http://localhost:8000/

# Inventory
http://localhost:8000/inventory

# Receipts
http://localhost:8000/receipt

# QC Queue
http://localhost:8000/qc/queue
```

---

**🎉 CHÚC BẠN SETUP THÀNH CÔNG!**

Nếu gặp vấn đề, liên hệ: wms-support@dailongfoods.com
