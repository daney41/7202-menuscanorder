<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuDataSeeder extends Seeder
{
    public function run()
    {
        // Insert categories
        $category_data = [
            ['name' => "not selected"],
            ['name' => "Coffee"],
            ['name' => "Meal"],
            ['name' => "Dessert"],
            ['name' => "Tea"]
        ];
        $this->db->table('Category')->insertBatch($category_data);

        // Insert milk types
        $milk_data = [
            ['milk_type' => "not selected"],
            ['milk_type' => "Full cream"],
            ['milk_type' => "Skim"],
            ['milk_type' => "Lactose free"],
            ['milk_type' => "Oat milk"],
            ['milk_type' => "Almond milk"],
            ['milk_type' => "Soy milk"]
        ];
        $this->db->table('Milks')->insertBatch($milk_data);

        // Insert sample data into the User table for multiple users
        $user_data = [
            [
                'cafe_name' => 'Sunshine Cafe',
                'email' => 'sunshinecafe@gmail.com',
                'password' => password_hash('sunshinecafe123', PASSWORD_DEFAULT),
                'address' => '2183 Mains Rd Sunnybank Hills',
            ],
            [
                'cafe_name' => 'Moonlight Bistro',
                'email' => 'moonlightbistro@gmail.com',
                'password' => password_hash('moonlightbistro123', PASSWORD_DEFAULT),
                'address' => '7c Farne Street Fortitude Valley',
            ],
            [
                'cafe_name' => 'Starry Night Diner',
                'email' => 'starrynightdiner@gmail.com',
                'password' => password_hash('starrynightdiner123', PASSWORD_DEFAULT),
                'address' => '79 Pinelands Rd Eight Mile Plains'
            ],
            [
                'cafe_name' => 'Green Leaf Cafe',
                'email' => 'greenleafcafe@gmail.com',
                'password' => password_hash('greenleafcafe123', PASSWORD_DEFAULT),
                'address' => '12 Oak Street, Brisbane'
            ],
            [
                'cafe_name' => 'Blue Sky Coffee',
                'email' => 'blueskycoffee@gmail.com',
                'password' => password_hash('blueskycoffee123', PASSWORD_DEFAULT),
                'address' => '45 Maple Road, Sydney'
            ]
            // Add more users as needed
        ];

        foreach ($user_data as $user) {
            $this->db->table('Users')->insert($user);
            $userId = $this->db->insertID();

            // Insert menu data
            $menu_data = [
                'user_id' => $userId,
                'menu_name' => "Menu $userId",
                'description' => "Description $userId",
            ];
            $this->db->table('Menus')->insert($menu_data);
            $menuId = $this->db->insertID();

            // Insert table data
            $table_data = [
                'user_id' => $userId,
                'status' => 'Available',
                'table_name' => 'Table ' . $userId,
            ];
            $this->db->table('Tables')->insert($table_data);

            // Insert dish data
            $dish_data = [
                // Coffee
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Espresso',
                    'description' => 'Strong and black coffee',
                    'price' => 3.00,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Cappuccino',
                    'description' => 'Coffee with steamed milk foam',
                    'price' => 4.00,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Latte',
                    'description' => 'Smooth coffee with steamed milk',
                    'price' => 4.50,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Americano',
                    'description' => 'Diluted espresso with water',
                    'price' => 3.50,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Mocha',
                    'description' => 'Chocolate flavored coffee',
                    'price' => 5.00,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Flat White',
                    'description' => 'Coffee with steamed milk',
                    'price' => 4.50,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Macchiato',
                    'description' => 'Espresso with a small amount of foamed milk',
                    'price' => 3.50,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Affogato',
                    'description' => 'Espresso poured over vanilla ice cream',
                    'price' => 4.00,
                    'category_id' => 2, // Coffee
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Irish Coffee',
                    'description' => 'Coffee with Irish whiskey and cream',
                    'price' => 6.00,
                    'category_id' => 2, // Coffee
                ],
                // Meals
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Ham Sandwich',
                    'description' => 'Sandwich with ham and cheese',
                    'price' => 5.50,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chicken Salad',
                    'description' => 'Fresh salad with grilled chicken',
                    'price' => 7.00,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Club Sandwich',
                    'description' => 'Triple layered sandwich with turkey, bacon, lettuce, and tomato',
                    'price' => 6.50,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Beef Burger',
                    'description' => 'Juicy beef burger with cheese, lettuce, and tomato',
                    'price' => 8.00,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Veggie Wrap',
                    'description' => 'Healthy wrap with assorted vegetables and hummus',
                    'price' => 6.00,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Grilled Cheese',
                    'description' => 'Toasted sandwich with melted cheese',
                    'price' => 4.50,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chicken Soup',
                    'description' => 'Warm soup with chicken and vegetables',
                    'price' => 5.00,
                    'category_id' => 3, // Meal
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Fish and Chips',
                    'description' => 'Fried fish with French fries',
                    'price' => 9.00,
                    'category_id' => 3, // Meal
                ],
                // Desserts
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Cheesecake',
                    'description' => 'Rich and creamy cheesecake',
                    'price' => 4.50,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chocolate Brownie',
                    'description' => 'Decadent chocolate brownie',
                    'price' => 3.50,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Fruit Tart',
                    'description' => 'Fresh tart with assorted fruits',
                    'price' => 5.00,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Ice Cream Sundae',
                    'description' => 'Ice cream with toppings and syrup',
                    'price' => 4.00,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Lemon Meringue Pie',
                    'description' => 'Tangy lemon pie with meringue topping',
                    'price' => 4.50,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chocolate Cake',
                    'description' => 'Rich and moist chocolate cake',
                    'price' => 5.00,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Panna Cotta',
                    'description' => 'Creamy Italian dessert',
                    'price' => 4.50,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Apple Pie',
                    'description' => 'Classic apple pie with a flaky crust',
                    'price' => 4.00,
                    'category_id' => 4, // Dessert
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Tiramisu',
                    'description' => 'Coffee-flavored Italian dessert',
                    'price' => 5.00,
                    'category_id' => 4, // Dessert
                ],
                // Tea
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Green Tea',
                    'description' => 'Refreshing green tea',
                    'price' => 2.50,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Herbal Tea',
                    'description' => 'Calming herbal tea blend',
                    'price' => 3.00,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Black Tea',
                    'description' => 'Strong black tea',
                    'price' => 2.50,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chamomile Tea',
                    'description' => 'Soothing chamomile tea',
                    'price' => 3.00,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Chai Latte',
                    'description' => 'Spiced tea with milk',
                    'price' => 4.00,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Earl Grey Tea',
                    'description' => 'Tea with a hint of bergamot',
                    'price' => 3.00,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Matcha Latte',
                    'description' => 'Green tea latte with matcha powder',
                    'price' => 4.50,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Peppermint Tea',
                    'description' => 'Refreshing peppermint tea',
                    'price' => 3.00,
                    'category_id' => 5, // Tea
                ],
                [
                    'menu_id' => $menuId,
                    'dish_name' => 'Jasmine Tea',
                    'description' => 'Fragrant jasmine tea',
                    'price' => 3.50,
                    'category_id' => 5, // Tea
                ]
            ];
            $this->db->table('Dishes')->insertBatch($dish_data);
        }
    }
}
