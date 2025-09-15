# Mini Restaurant API

A Laravel-based restaurant management API system for handling orders, bookings, menu items, and payments.

## Quick Start

### Prerequisites

-   PHP 8.1+
-   Composer
-   MySQL

### Installation

1. **Clone and install dependencies**

```bash
git clone <repository-url>
cd mini_restaurant
composer install
```

2. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

3. **Database configuration**
   Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_restaurant
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Database setup**

```bash
php artisan migrate
php artisan db:seed
```

5. **Start the server**

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Authentication

-   `POST /api/auth/register` - Register customer
-   `POST /api/auth/login` - Login customer
-   `GET /api/auth/profile` - Get profile (authenticated)

### Menu

-   `GET /api/menu` - List all menu items
-   `GET /api/menu/{id}` - Get menu item details
-   `GET /api/menu/search` - Search menu items

### Orders

-   `GET /api/orders` - List customer orders (authenticated)
-   `POST /api/orders` - Create new order (authenticated)
-   `GET /api/orders/{id}` - Get order details (authenticated)
-   `POST /api/orders/{id}/payment` - Complete payment (authenticated)

### Tables & Bookings

-   `GET /api/tables/available` - Get available tables
-   `POST /api/bookings` - Create booking (authenticated)
-   `GET /api/bookings` - List bookings (authenticated)

### Payment

-   `GET /api/payment/options` - Get payment options
-   `GET /api/invoices/order/{orderId}` - Get order invoice

## Order Flow

1. **Browse Menu**: `GET /api/menu`
2. **Create Order**: `POST /api/orders` with menu items
3. **Complete Payment**: `POST /api/orders/{id}/payment` with payment option

## Sample Request

**Create Order:**

```json
POST /api/orders
{
  "items": [
    {
      "menu_item_id": 1,
      "quantity": 2
    }
  ]
}
```

**Complete Payment:**

```json
POST /api/orders/{id}/payment
{
  "payment_option_id": 1
}
```

## Features

-   ✅ Customer authentication
-   ✅ Menu management with availability tracking
-   ✅ Order creation with inventory management
-   ✅ Two-step payment process
-   ✅ Table booking system
-   ✅ Waiting list management
-   ✅ Invoice generation
-   ✅ Discount and tax calculations

## Database

The system includes seeders for:

-   Menu items with pricing and discounts
-   Tables with different capacities
-   Payment options with tax/service charges

Run `php artisan db:seed` to populate sample data.

## Development

**Reset database:**

```bash
php artisan migrate:fresh --seed
```

**Clear cache:**

```bash
php artisan cache:clear
php artisan config:clear
```

## Support

For issues or questions, please check the API documentation or contact the development team.
