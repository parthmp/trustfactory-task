# Mini E-Commerce Demo

## Overview

This is a demo e-commerce application built with Laravel 12 + Inertia.js + Vue 3. It includes core shopping cart functionality, checkout, stock validation, low-stock notifications, and daily sales reports.

## Features Implemented

* Product listing with stock status
* Cart management:
  * Add/remove items
  * Quantity validation against available stock
* Checkout process:
  * Deducts stock quantities from products
  * Generates orders and order items
* Low stock notifications sent to admin if product quantity drops below 10
* Daily sales report emailed to admin with order details, items, quantities, and totals
* Flash messages for user feedback (using `vue-sonner`)
* Minimal unit tests for core cart logic
* Transaction-safe operations for all critical actions
* Precision math for monetary calculations using `brick/math` to avoid floating-point errors

## Installation

1. Clone the repository:

```bash
git clone <your-repo-link>
cd <repo-folder>
```

2. Install dependencies:

```bash
composer install
npm install
npm run build
```

3. Set up environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations & seed fake data:

```bash
php artisan migrate --seed
```

5. Run development server:

```bash
php artisan serve
npm run dev
```

## Usage

* Visit `/` to browse products
* Add items to your cart
* Checkout to create orders and update stock
* Admin email notifications:
  * Low stock notifications are sent automatically via scheduled command
  * Daily sales report runs at 12:00 AM via Laravel scheduler

## Testing

Run tests:

```bash
php artisan test
```

Covers:
* Adding items to cart
* Quantity validation logic

## Technical Notes

* This is a demo task, so some areas (e.g., full unit test coverage, UI polish) are simplified
* Uses Inertia.js + Vue 3 + Tailwind CSS for frontend SPA-like behavior
* Flash notifications are handled via `vue-sonner`
* All critical actions are transaction-safe
* Uses `brick/math` library for precise monetary calculations to prevent floating-point arithmetic errors in cart totals and pricing