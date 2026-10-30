# Wedding-Management

# EverAfter – Wedding Management System

A web-based **wedding planning and vendor marketplace**. Customers plan their event and discover, shortlist and book vendors; vendors manage their business profile, portfolio, enquiries and bookings; administrators manage the platform.

> College project – BCA (Computer Science), SSBE'S INSTITUE OF TECHNOLOGY AND MANAGEMENT (Swami Ramanand Teerth Marathwada University, Nanded), 2026–2027.

---

## Features

### Customer
- Register / log in and create a wedding or other event with required services
- *Active event* concept – shortlists, bookings, guests and budget all belong to the selected event
- Browse approved vendors with search and category / city filters
- Vendor detail page with portfolio gallery, price, experience and reviews
- Shortlist vendors, send enquiries and create bookings
- Guest list management and budget / expense tracking
- Rate and review a vendor after a booking is **Completed**

### Vendor
- Separate dashboard with enquiry, booking and revenue summary
- Manage business profile (category, city, price, experience, description)
- Upload and delete portfolio images
- Update booking status: Pending → Confirmed → Completed / Cancelled

### Administrator
- Platform overview and statistics
- Manage users, vendors (approval / moderation) and bookings

### Security
- Passwords stored with `password_hash()` / verified with `password_verify()`
- PDO prepared statements for all queries
- Session-based login with role checks (customer / vendor / admin)
- Ownership checks on events, bookings and vendor data
- Public registration limited to customer and vendor roles

---

## Tech Stack

| Layer | Technology |
|---|---|
| Front end | HTML5, CSS3, JavaScript (Fetch API) |
| Back end | PHP (PDO, sessions) – single JSON API in `php/api.php` |
| Database | MySQL / MariaDB (`wedding_management`) |
| Server | Apache via XAMPP |
| Editor | Visual Studio Code |

---

## Project Structure

```
Wedding Management/
├── assets/images/
├── css/            style.css, dashboard.css, vendor.css, admin.css
├── js/             app.js, dashboard.js
├── php/
│   ├── api.php         central JSON API
│   ├── auth.php        session + role helpers
│   ├── config.php      database connection
│   ├── sidebar.php, vendor-sidebar.php, admin-sidebar.php
│   ├── seed-demo-vendors.php
│   └── uploads/        vendor images (not committed)
├── index.html, login.php, register.php, profile.php, change-password.php
├── dashboard.php, plan-event.php, my-events.php, planner.php
├── vendors.php, vendor-details.php, shortlist.php, bookings.php
├── guests.php, budget.php
├── vendor-dashboard.php, vendor-profile.php, vendor-enquiries.php, vendor-bookings.php
├── admin-dashboard.php, admin-users.php, admin-vendors.php, admin-bookings.php
└── database/       wedding_management.sql  (export from phpMyAdmin)
```

---

## Getting Started

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (Apache, PHP 7.4+ with PDO enabled, MariaDB)
- A modern web browser

### Installation

1. **Clone the repository** into the XAMPP web folder:
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/<your-username>/<repo-name>.git "Wedding Management"
   ```
2. **Start** Apache and MySQL from the XAMPP Control Panel.
3. **Create the database**
   - Open <http://localhost/phpmyadmin>
   - Create a database named `wedding_management`
   - Import `database/wedding_management.sql`
4. **Configure the connection** – copy `php/config.example.php` to `php/config.php` and set your values:
   ```php
   $host = "localhost";
   $db   = "wedding_management";
   $user = "root";
   $pass = "";
   ```
5. **Create the uploads folder** (if missing): `php/uploads/` and make sure it is writable.
6. **Open the app:** <http://localhost/Wedding%20Management/>

### Optional – demo vendors
To fill the marketplace with sample vendors, run `php/seed-demo-vendors.php` once from the browser.

---

## Quick Test Flow

1. Register a **vendor** account → complete the profile and upload portfolio images.
2. Log in as **admin** → approve the vendor.
3. Register a **customer** → *Plan Event* → browse vendors → shortlist / enquire / book.
4. Log in as the vendor → change the booking to **Completed**.
5. Log in as the customer → write a review for that booking.

---

## Screenshots

Add real screenshots to `docs/screenshots/` and link them here:

| Home | Customer Dashboard | Vendor Marketplace |
|---|---|---|
| ![Home](docs/screenshots/home.png) | ![Dashboard](docs/screenshots/dashboard.png) | ![Vendors](docs/screenshots/vendors.png) |

---

## Database Overview

Main tables: `users`, `events`, `event_services`, `guests`, `expenses`, `vendors`, `vendor_profiles`, `vendor_images`, `vendor_enquiries`, `vendor_shortlists`, `bookings`, `reviews`.

---

## Roadmap

- Vendor claim and verification
- Category / subcategory navigation and advanced search
- Vendor availability calendar
- Online payment gateway
- E-mail / SMS notifications
- Security hardening: HTTPS, CSRF protection, rate limiting, e-mail verification, password reset
- Multi-city deployment and mobile app


---

## License

This project was developed for educational purposes. Add a license of your choice (for example MIT) before reusing it publicly.
