<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



💎 Cosmetic Clinic Management System

A production-ready Cosmetic Clinic appointment management system built with Laravel.

This system allows patients to book treatments while preventing scheduling conflicts and enables administrators to manage business hours, appointments, and clinic operations efficiently.

⸻

🚀 Features

👤 Authentication & Roles
	•	Secure Login & Registration
	•	Role-Based Access Control (Admin / Patient)
	•	Admin-only protected routes

📅 Appointment System
	•	Treatment booking
	•	Automatic conflict prevention logic
	•	Dynamic business hours validation
	•	Past-date booking prevention
	•	Appointment status management (Booked / Completed / Cancelled)
	•	Patient-controlled cancellation
	•	Admin-controlled completion

📊 Admin Dashboard
	•	Total Appointments counter
	•	Booked / Completed statistics
	•	Services count
	•	Appointment filtering
	•	Pagination
	•	Clean UI dashboard

⚙️ Dynamic Configuration
	•	Admin can update business hours
	•	Booking system automatically adapts to new hours

🧠 Backend Logic
	•	Time-slot generation
	•	Duration-based overlap detection
	•	Role-based route protection
	•	MVC clean architecture

⸻

🛠 Tech Stack
	•	Laravel
	•	PHP 8
	•	MySQL
	•	Tailwind CSS
	•	Blade Templates
	•	Chart.js

⸻

🧠 Key Implementation Highlights
	•	Implemented advanced appointment conflict validation logic to prevent overlapping bookings.
	•	Built dynamic business hours management system controlled by admin.
	•	Designed role-based dashboards with restricted route access.
	•	Structured clean MVC architecture following Laravel best practices.
