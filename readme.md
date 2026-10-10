# Tourism

A PHP-based tourism website for browsing destinations, discovering attractions, and booking tours. The project uses a lightweight MVC structure, MySQL for data storage, and a custom PHP rendering layer for views.

## Overview

This application presents destination-focused travel content for countries such as Armenia, France, Italy, and the USA. Users can:

- explore curated attraction pages
- browse featured country highlights
- view upcoming tour packages
- sign up or sign in
- book tours after authentication
- review their booked trips

The site is designed for local development with XAMPP and runs through Apache and MySQL.

## Features

- Home page with promotional destination sections and featured attractions
- country-based attraction listing and detailed attraction pages
- tour catalog with travel dates, durations, and destinations
- user authentication (sign in / sign up)
- booking flow with a card number validation check
- personal bookings page showing the user's reserved tours
- responsive styling and JavaScript-based UI interactions

## Tech Stack

- PHP 8+
- MySQL
- Apache
- Custom MVC router and controllers
- CSS and JavaScript for front-end interactions

## Project Structure

```text
Tourism/
├── .htaccess
├── index.php
├── readme.md
├── assets/
│   ├── app-data/
│   │   ├── config.php
│   │   ├── db/
│   │   │   ├── tourism.sql
│   │   │   └── backup/
│   │   └── dependencies.php
│   ├── controllers/
│   ├── models/
│   ├── routers/
│   ├── scripts/
│   └── views/
├── public/
│   ├── images/
│   └── styles/
└── tourism.zip
```

## Database

The application expects a MySQL database named `tourism`.

The schema and sample data are available in:

- [assets/app-data/db/tourism.sql](assets/app-data/db/tourism.sql)

The project includes tables for:

- `users`
- `tours`
- `attractions`
- `bookings`

## Local Setup

### 1. Install and run XAMPP

Install XAMPP and make sure Apache and MySQL are running.

### 2. Place the project in the correct folder

Place the project under:

```text
C:/xampp/htdocs/Tourism
```

The app expects the project folder name to be exactly `Tourism`.

### 3. Import the database

- open phpMyAdmin
- create a database named `tourism`
- import [assets/app-data/db/tourism.sql](assets/app-data/db/tourism.sql)

### 4. Check the configuration

The database configuration is defined in [assets/app-data/config.php](assets/app-data/config.php).

Default local settings are:

```php
self::$db->host = 'localhost';
self::$db->name = 'tourism';
self::$db->username = 'root';
self::$db->pwd = '';
```

If your local MySQL credentials differ, update them there.

## Run the App

Open the following URL in your browser:

```text
http://localhost/Tourism
```

You may also access the individual pages through the app's routing system, including:

- `/` — home page
- `/attractions` — attraction list
- `/attraction?id=...` — individual attraction page
- `/auth/signin` — sign in
- `/auth/signup` — sign up
- `/bookings` — user bookings

## Notes

- The app uses a custom router with request handlers defined in [index.php](index.php).
- Static assets are served from the [public](public) directory.
- Authentication is required for booking a tour.
- The database file includes sample tours, attractions, and users for testing.

## Troubleshooting

If the project does not load correctly, verify the following:

- the database is running in MySQL
- the database name is exactly `tourism`
- the project folder is named `Tourism`
- the credential values in [assets/app-data/config.php](assets/app-data/config.php) match your local environment
- Apache is serving the project from `htdocs`

## License

This project is a local educational/demo application and is intended for learning and development purposes.

