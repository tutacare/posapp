# 📦 Tutorial Instalasi POSApp (Laravel 12 + Vite + TailwindCSS)

**POSApp** adalah aplikasi kasir berbasis web yang dibangun menggunakan Laravel 12, Vite, dan Tailwind CSS. Cocok untuk kebutuhan usaha kecil hingga menengah.

---

## ✅ Persyaratan Sistem

Sebelum memulai instalasi, pastikan server atau perangkat lokal kamu telah terpasang:

-   PHP >= 8.2
-   MySQL atau PostgreSQL
-   Composer
-   Node.js >= 18 + NPM
-   Git (opsional)

---

## 🛠️ Langkah-langkah Instalasi

### 1. Download Source

Ekstrak file ZIP aplikasi ke dalam folder `htdocs/` (XAMPP) atau `www/` (Laragon, dll).

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install && npm run build
```

### 4. Copy File .env

```bash
cp .env.example .env
```

### 5. Generate Key Aplikasi

```bash
php artisan key:generate
```

### 6. Atur Konfigurasi Database (PostgreSQL)

Edit file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=posapp
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 7. Migrate dan Seed Database

```bash
php artisan migrate --seed
```

### 8. Link Storage

```bash
php artisan storage:link
```

### 9. Jalankan Server

```bash
php artisan serve
```

Akses melalui browser: [http://localhost:8000](http://localhost:8000)

---

## 🧪 Login Default

-   **Email:** `admin@example.com`
-   **Password:** `password`

---

**Selamat menggunakan POSApp!** 🎉
