# 🏠 RentHub

RentHub is a web-based rental house management system built with **Laravel 13** and **Filament 4**. It helps property owners manage rooms, tenants, leases, payments, and expenses through a modern admin dashboard.

RentHub is also available as a **Progressive Web App (PWA)**, allowing users to install it on desktop and Android devices for a more app-like experience.

---

## ✨ Features

- 🔐 Authentication & Authorization
- 👥 Tenant Management
- 🏠 Room Management
- 📄 Lease Management
- 💳 Payment Management
- 💰 Expense Tracking
- 📊 Dashboard & Statistics
- 📱 Progressive Web App (PWA)
- 🎨 Responsive Admin Interface

---

## 🛠️ Tech Stack

- Laravel 13
- Filament 4
- PHP 8.3+
- MySQL
- Tailwind CSS
- Alpine.js
- Laravel Herd
- Progressive Web App (PWA)

---

## 📱 Progressive Web App

RentHub supports Progressive Web App (PWA) features:

- Installable on Desktop
- Installable on Android
- Secure HTTPS
- Web App Manifest
- Service Worker
- Standalone App Experience

---

## 🚀 Installation

Clone the repository

```bash
git clone https://github.com/yourusername/renthub.git
```

Go to project folder

```bash
cd renthub
```

Install dependencies

```bash
composer install
npm install
```

Copy environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure your database inside `.env`

Run migrations

```bash
php artisan migrate --seed
```

Start the development server

```bash
php artisan serve
```

For frontend assets

```bash
npm run dev
```

---

## 📸 Screenshots

### Dashboard

> Add dashboard screenshot here.

### Room Management

> Add room management screenshot here.

### Tenant Management

> Add tenant management screenshot here.

---

## 📂 Project Structure

```
app/
resources/
routes/
database/
public/
```

---

## 📄 License

This project is licensed under the MIT License.
