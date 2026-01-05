# Mini E-Commerce Demo

## Overview

This is a demo e-commerce application built with Laravel 12 + Inertia.js + Vue 3. It includes core shopping cart functionality, checkout, stock validation, low-stock notifications, and daily sales reports.

## Features Implemented

* **Product Management:**
  * Products table, migration, and model with stock tracking
  * Stock status display (in stock/out of stock based on quantity)
  * Products factory for generating fake data with Faker
* **Cart Management:**
  * Cart items table, migration, and model
  * Add/remove items with real-time stock validation
  * Prevents adding quantities exceeding available stock
  * Quantity validation at cart and checkout stages
* **Checkout Process:**
  * Cart validation against current stock before processing
  * Stock availability checks (alerts if products become unavailable)
  * Order creation with order items
  * Automatic stock deduction upon successful checkout
  * Cart clearing after order completion
* **Admin Notifications:**
  * Low stock email alerts when product quantity drops below 10 (via Laravel command)
  * Daily sales report sent at 11:59 PM via Laravel scheduler
  * Sales report includes: order numbers, items, quantities, amounts, and final totals
* **Technical Implementation:**
  * Flash messages for user feedback (using `vue-sonner`)
  * Precision math for monetary calculations using `brick/math`
  * A couple of unit tests for core cart logic
  * Transaction-safe operations for critical actions

1. Clone the repository:

```bash
git clone https://github.com/parthmp/trustfactory-task/
cd trustfactory-task
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

5. Configure Laravel scheduler (for daily sales reports):

Add to your crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or for local development, run:
```bash
php artisan schedule:work
```

6. Run development server:

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

## Scheduled Commands

* **Low Stock Check:** Runs via Laravel command to check inventory and send email alerts for products below threshold (quantity < 10)
* **Daily Sales Report:** Runs at 11:59 PM daily, generates comprehensive sales report for all orders placed that day, including order numbers, items, quantities, and totals

## Testing

Run tests:

```bash
php artisan test
```

Test coverage includes:
* Adding items to cart with stock validation
* Quantity validation logic
* Stock availability checks

## Technical Notes

* This is a demo task, so some areas (e.g., full unit test coverage, UI polish) are simplified
* Uses Inertia.js + Vue 3 + Tailwind CSS for frontend SPA-like behavior
* Flash notifications are handled via `vue-sonner`
* Demonstration of transaction-safe critical actions 
* Uses `brick/math` library for precise monetary calculations to prevent floating-point arithmetic errors in cart totals and pricing
