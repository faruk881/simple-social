# Simple Social API

Simple Social is a RESTful API project built with **Laravel** and secured using **Laravel Sanctum**.  
It provides a backend foundation for a basic social media platform with role-based access control and moderation.

---

## 🚀 Features

### 🔐 Authentication & Authorization
- Token-based authentication using Laravel Sanctum
- User registration & login
- Role-based access control
  - **Admin**
  - **Normal User**

### 👤 Users
- User creation and authentication
- Role management (Admin / Normal User)

### 📝 Posts
- Users can create posts
- Admin approval required before posts become public
- Admin can approve or reject posts

### 💬 Comments & Replies
- Users can comment on posts
- Users can reply to comments (nested replies supported)

### ❤️ Likes
- Like / unlike posts
- Like / unlike comments

### 🚩 Reports
- Users can report posts or comments
- Admin can review reported content

---

## 🛠️ Tech Stack

- **Laravel**
- **Laravel Sanctum**
- **MySQL**
- **REST API**

---

## ⚙️ Installation

```bash
git clone <your-repository-url>
cd simple-social
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
