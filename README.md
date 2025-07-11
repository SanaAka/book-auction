# 📖 Book Auction Platform

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License">
</p>

A dynamic web application built with Laravel for hosting and participating in real-time book auctions.  
This platform allows administrators to manage books and auctions, while users can register via social login to place bids and receive live notifications.

---

## ✨ Features

### 🔐 Separate User & Admin Roles
- ✅ **Social-Only User Login:** Users register & log in via social providers (e.g., Google).
- ✅ **Dedicated Admin Login:** Admins have a separate, secure login form.

### 📚 Complete Auction Lifecycle
- ✅ **Auction Creation:** Admins select books and launch auctions with custom start/end times and prices.
- ✅ **Live Bidding:** Users bid on active auctions. Bids must be higher than the current top bid.
- ✅ **Automated Closing:** Auctions auto-close at the end time, declaring the highest bidder the winner.
- ✅ **Manual Closing:** Admins can close any auction manually.

### 🔔 Real-Time User Alerts
- ✅ **Outbid Notifications:** Users get instant emails when outbid.
- ✅ **Win Notifications:** Winners get a congratulatory email when an auction closes.
- ✅ **Ending Soon Reminders:** A daily task alerts bidders about auctions ending within 24 hours.

### 📊 Functional Dashboards
- ✅ **Admin Dashboard:** Manage books, auctions, statuses, and winners.
- ✅ **User Dashboard:** Track active bids and view won auctions.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Database:** MySQL
- **Authentication:** Laravel Socialite (Google Login)
- **Frontend:** Blade Templates, CSS, Vanilla JavaScript
- **Email:** SMTP (Mailtrap for local testing)
- **Scheduling:** Laravel Task Scheduler & Cron

---

## 🚀 Getting Started

Follow these steps to run the project locally for development & testing.

### ✅ Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL database

### ✅ Installation

1️⃣ Clone the repository:
```bash
git clone https://github.com/SanaAka/book-auction.git
cd book-auction
