# 📖 Book Auction Platform

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License">
</p>

A dynamic web app built with Laravel for hosting and participating in real-time book auctions.  
Admins manage books & auctions, while users register via social login to place bids and get live notifications.

---

## ✨ Features

### 🔐 Separate User & Admin Roles
- ✅ Social-only user login (Google)
- ✅ Dedicated admin login

### 📚 Complete Auction Lifecycle
- ✅ Admins create auctions
- ✅ Live bidding with bid validation
- ✅ Automated & manual auction closing

### 🔔 Real-Time Alerts
- ✅ Outbid notifications
- ✅ Winner notifications
- ✅ Ending soon reminders

### 📊 Dashboards
- ✅ Admin panel: manage books, auctions, winners
- ✅ User panel: track bids & history

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Database:** MySQL
- **Auth:** Laravel Socialite
- **Frontend:** Blade, CSS, JS
- **Email:** SMTP (Mailtrap for dev)
- **Scheduling:** Laravel Scheduler & Cron

---

## 🚀 All-in-One Setup

### ✅ One Command Flow

Copy & run these commands to install everything at once:

```bash
# Clone project & go into it
git clone https://github.com/SanaAka/book-auction.git
cd book-auction

# Install PHP & JS dependencies
composer install && npm install

# Copy env & generate key
cp .env.example .env && php artisan key:generate

# Run migrations with seeders
php artisan migrate:fresh --seed

# Build frontend assets
npm run build
```
# Next:

## 1.Edit your .env with your:

## 2.Start the servers:
```bash
php artisan serve
npm run dev
```
# Next step
 1.Open: http://127.0.0.1:8000

 2.Admin Credentials:

 3.Email: admin@example.com

 4.Password: password


---

**Key point:**  
✅ This version lets someone run a **single block of commands** to set up everything from clone to build.  
✅ Clear instructions for `.env` updates & local servers.  
✅ Works for new devs, easy copy-paste.

If you want, I can save this as a `README.md` file and show you exactly how to push it to your repo — just say **“Yes, save & push!”** 🚀✨
