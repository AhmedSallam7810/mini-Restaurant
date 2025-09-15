<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $menuItems = [
            [
                'name' => 'Caesar Salad',
                'description' => 'Fresh romaine lettuce with parmesan cheese, croutons and caesar dressing',
                'price' => 12.99,
                'daily_limit' => 50,
                'current_amount' => 50,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Garlic Bread',
                'description' => 'Toasted bread with garlic butter and herbs',
                'price' => 8.99,
                'daily_limit' => 100,
                'current_amount' => 100,
                'discount' => 1.00,
                'is_active' => true
            ],
            [
                'name' => 'Buffalo Wings',
                'description' => '8 pieces of spicy buffalo chicken wings with ranch dip',
                'price' => 15.99,
                'daily_limit' => 40,
                'current_amount' => 40,
                'discount' => 0,
                'is_active' => true
            ],

            [
                'name' => 'Margherita Pizza',
                'description' => 'Classic pizza with tomato sauce, mozzarella and fresh basil',
                'price' => 18.99,
                'daily_limit' => 30,
                'current_amount' => 30,
                'discount' => 2.00,
                'is_active' => true
            ],
            [
                'name' => 'Pepperoni Pizza',
                'description' => 'Traditional pizza with pepperoni and mozzarella cheese',
                'price' => 21.99,
                'daily_limit' => 35,
                'current_amount' => 35,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Grilled Salmon',
                'description' => 'Fresh Atlantic salmon with lemon butter sauce and vegetables',
                'price' => 28.99,
                'daily_limit' => 20,
                'current_amount' => 20,
                'discount' => 3.00,
                'is_active' => true
            ],
            [
                'name' => 'Ribeye Steak',
                'description' => '12oz premium ribeye steak with garlic mashed potatoes',
                'price' => 35.99,
                'daily_limit' => 15,
                'current_amount' => 15,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Chicken Alfredo',
                'description' => 'Grilled chicken breast with fettuccine in creamy alfredo sauce',
                'price' => 22.99,
                'daily_limit' => 25,
                'current_amount' => 25,
                'discount' => 1.50,
                'is_active' => true
            ],
            [
                'name' => 'Vegetarian Pasta',
                'description' => 'Penne pasta with seasonal vegetables in marinara sauce',
                'price' => 19.99,
                'daily_limit' => 30,
                'current_amount' => 30,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Fish and Chips',
                'description' => 'Beer battered cod with crispy fries and tartar sauce',
                'price' => 17.99,
                'daily_limit' => 25,
                'current_amount' => 25,
                'discount' => 2.50,
                'is_active' => true
            ],

            [
                'name' => 'Chocolate Cake',
                'description' => 'Rich chocolate layer cake with chocolate ganache',
                'price' => 9.99,
                'daily_limit' => 20,
                'current_amount' => 20,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Tiramisu',
                'description' => 'Classic Italian dessert with coffee-soaked ladyfingers',
                'price' => 11.99,
                'daily_limit' => 15,
                'current_amount' => 15,
                'discount' => 1.00,
                'is_active' => true
            ],
            [
                'name' => 'Ice Cream Sundae',
                'description' => 'Vanilla ice cream with chocolate sauce and whipped cream',
                'price' => 7.99,
                'daily_limit' => 50,
                'current_amount' => 50,
                'discount' => 0,
                'is_active' => true
            ],

            [
                'name' => 'Fresh Orange Juice',
                'description' => 'Freshly squeezed orange juice',
                'price' => 4.99,
                'daily_limit' => 100,
                'current_amount' => 100,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Coffee',
                'description' => 'Premium roasted coffee beans',
                'price' => 3.99,
                'daily_limit' => 200,
                'current_amount' => 200,
                'discount' => 0.50,
                'is_active' => true
            ],
            [
                'name' => 'Craft Beer',
                'description' => 'Local craft beer selection',
                'price' => 6.99,
                'daily_limit' => 80,
                'current_amount' => 80,
                'discount' => 0,
                'is_active' => true
            ],

            // Limited/Special Items
            [
                'name' => 'Lobster Thermidor',
                'description' => 'Fresh lobster in creamy thermidor sauce - Chef Special',
                'price' => 45.99,
                'daily_limit' => 5,
                'current_amount' => 5,
                'discount' => 0,
                'is_active' => true
            ],
            [
                'name' => 'Truffle Risotto',
                'description' => 'Creamy arborio rice with black truffle shavings',
                'price' => 32.99,
                'daily_limit' => 8,
                'current_amount' => 8,
                'discount' => 0,
                'is_active' => true
            ]
        ];

        MenuItem::insert($menuItems);
    }
}
