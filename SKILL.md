---
name: codecraft-laravel-xampp-architecture
description: Panduan arsitektur Full-Stack Laravel (XAMPP Environment), skema database MySQL, dan UI/UX interaktif untuk platform edukasi SMP "CodeCraft" berdasarkan referensi desain Bento/Editorial Playful.
---

# CodeCraft Laravel (XAMPP) & Interactive UI Skill

Gunakan panduan ini setiap kali membangun fitur backend, database MySQL (XAMPP), komponen Blade, dan animasi antarmuka untuk platform **CodeCraft** (Web Lab Coding & Jaringan Komputer Dasar tingkat SMP).

## 1. Lingkungan Server & Konfigurasi XAMPP
* **Environment:** Windows + XAMPP (Apache & MySQL aktif). Jika perintah `php` di terminal merujuk ke Laravel Herd yang error, gunakan binary PHP dari XAMPP secara eksplisit (`C:\xampp\php\php.exe`) dan MySQL dari (`C:\xampp\mysql\bin\mysql.exe`).
* **Local Development Server:** Jalankan menggunakan `php artisan serve` (`http://127.0.0.1:8000`).
* **Konfigurasi Database (`.env`):**
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=codecraft_db
  DB_USERNAME=root
  DB_PASSWORD=