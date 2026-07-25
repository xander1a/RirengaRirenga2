<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\BarEvent;
use App\Models\BarPromotion;
use App\Models\BlogPost;
use App\Models\CareerPosition;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::firstOrCreate(['name' => 'director']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'customer']);

        // Demo users
        $directorUser = User::factory()->create([
            'name'     => 'Rirenga Director',
            'email'    => 'director@rirenga.com',
            'password' => Hash::make('director123'),
            'phone'    => '+250788000001',
        ]);
        $directorUser->assignRole('director');

        $managerUser = User::factory()->create([
            'name'     => 'Rirenga Manager',
            'email'    => 'manager@rirenga.com',
            'password' => Hash::make('manager123'),
            'phone'    => '+250788000002',
        ]);
        $managerUser->assignRole('manager');

        $staffUser = User::factory()->create([
            'name'     => 'Rirenga Staff',
            'email'    => 'staff@rirenga.com',
            'password' => Hash::make('staff123'),
            'phone'    => '+250788000003',
        ]);
        $staffUser->assignRole('staff');

        $customerUser = User::factory()->create([
            'name'     => 'Jane Guest',
            'email'    => 'guest@example.com',
            'password' => Hash::make('guest123'),
            'phone'    => '+250788000004',
        ]);
        $customerUser->assignRole('customer');

        // Room types
        $dbl = RoomType::create([
            'code'            => 'DBL',
            'name'            => 'Double Room',
            'description'     => 'Spacious double room with a queen-sized bed, ensuite bathroom, and private terrace overlooking the forest. Includes daily dinner and breakfast.',
            'price_per_night' => 150.00,
            'max_guests'      => 2,
            'amenities'       => ['Dinner & Breakfast Included', 'Private Terrace', 'Ensuite Bathroom', 'Hiking Access', 'Free WiFi', 'Forest View'],
            'is_active'       => true,
        ]);

        $twin = RoomType::create([
            'code'            => 'TWIN',
            'name'            => 'Twin Room',
            'description'     => 'Elegant twin room with two single beds, perfect for friends or colleagues. Features a garden view and all eco-lodge amenities. Includes daily dinner and breakfast.',
            'price_per_night' => 150.00,
            'max_guests'      => 2,
            'amenities'       => ['Dinner & Breakfast Included', 'Garden View', 'Ensuite Bathroom', 'Hiking Access', 'Free WiFi'],
            'is_active'       => true,
        ]);

        $sgl = RoomType::create([
            'code'            => 'SGL',
            'name'            => 'Single Room',
            'description'     => 'Cosy single room ideal for solo travellers. Includes daily dinner and breakfast.',
            'price_per_night' => 90.00,
            'max_guests'      => 1,
            'amenities'       => ['Dinner & Breakfast Included', 'Ensuite Bathroom', 'Hiking Access', 'Free WiFi'],
            'is_active'       => true,
        ]);

        // 5 physical rooms
        Room::create(['room_type_id' => $dbl->id,  'name' => 'Forest Suite',  'room_number' => '101']);
        Room::create(['room_type_id' => $dbl->id,  'name' => 'River View',    'room_number' => '102']);
        Room::create(['room_type_id' => $twin->id, 'name' => 'Garden Twin',   'room_number' => '201']);
        Room::create(['room_type_id' => $sgl->id,  'name' => 'Canopy Single', 'room_number' => '301']);
        Room::create(['room_type_id' => $sgl->id,  'name' => 'Hill Single',   'room_number' => '302']);

        // Restaurant menu categories & items
        $bfast    = MenuCategory::create(['name' => 'Breakfast', 'name_fr' => 'Petit-déjeuner', 'type' => 'restaurant', 'sort_order' => 0]);
        $starters = MenuCategory::create(['name' => 'Starters', 'name_fr' => 'Entrées', 'type' => 'restaurant', 'sort_order' => 1]);
        $mains    = MenuCategory::create(['name' => 'Main Courses', 'name_fr' => 'Plats Principaux', 'type' => 'restaurant', 'sort_order' => 2]);
        $desserts = MenuCategory::create(['name' => 'Desserts', 'name_fr' => 'Desserts', 'type' => 'restaurant', 'sort_order' => 3]);

        MenuItem::create(['menu_category_id' => $bfast->id, 'name' => 'Full Rwanda Breakfast', 'name_fr' => 'Petit-déjeuner Rwandais Complet', 'description' => 'Eggs, fresh fruit, local bread, tea or coffee', 'price' => 12.00]);
        MenuItem::create(['menu_category_id' => $bfast->id, 'name' => 'Continental Breakfast', 'name_fr' => 'Petit-déjeuner Continental', 'description' => 'Pastry, yogurt, juice and hot beverage', 'price' => 9.00]);
        MenuItem::create(['menu_category_id' => $starters->id, 'name' => 'Avocado & Tomato Salad', 'name_fr' => 'Salade Avocat & Tomate', 'description' => 'Fresh garden vegetables with lemon dressing', 'price' => 7.00]);
        MenuItem::create(['menu_category_id' => $starters->id, 'name' => 'Pumpkin Soup', 'name_fr' => 'Soupe de Citrouille', 'description' => 'Creamy roasted pumpkin, ginger & coconut milk', 'price' => 8.00]);
        MenuItem::create(['menu_category_id' => $mains->id, 'name' => 'Grilled Tilapia', 'name_fr' => 'Tilapia Grillé', 'description' => 'Whole tilapia, chips, plantain & salad', 'price' => 18.00]);
        MenuItem::create(['menu_category_id' => $mains->id, 'name' => 'Beef Brochettes', 'name_fr' => 'Brochettes de Boeuf', 'description' => 'Marinated beef skewers with ugali & vegetables', 'price' => 16.00]);
        MenuItem::create(['menu_category_id' => $mains->id, 'name' => 'Vegetable Curry', 'name_fr' => 'Curry de Légumes', 'description' => 'Seasonal vegetables in mild coconut curry, rice', 'price' => 14.00]);
        MenuItem::create(['menu_category_id' => $mains->id, 'name' => 'Chicken Ibinyugunyugu', 'name_fr' => 'Poulet Ibinyugunyugu', 'description' => 'Traditional Rwandan chicken stew, plantain', 'price' => 17.00]);
        MenuItem::create(['menu_category_id' => $desserts->id, 'name' => 'Passion Fruit Sorbet', 'name_fr' => 'Sorbet Fruit de la Passion', 'description' => 'Refreshing homemade sorbet', 'price' => 6.00]);
        MenuItem::create(['menu_category_id' => $desserts->id, 'name' => 'Chocolate Lava Cake', 'name_fr' => 'Fondant au Chocolat', 'description' => 'Warm chocolate cake with vanilla ice cream', 'price' => 8.00]);

        // Bar menu
        $cocktails = MenuCategory::create(['name' => 'Signature Cocktails', 'name_fr' => 'Cocktails Signature', 'type' => 'bar', 'sort_order' => 1]);
        $mocktails = MenuCategory::create(['name' => 'Mocktails', 'name_fr' => 'Mocktails', 'type' => 'bar', 'sort_order' => 2]);
        $beers     = MenuCategory::create(['name' => 'Beers & Ciders', 'name_fr' => 'Bières & Cidres', 'type' => 'bar', 'sort_order' => 3]);
        $wines     = MenuCategory::create(['name' => 'Wines', 'name_fr' => 'Vins', 'type' => 'bar', 'sort_order' => 4]);
        $softs     = MenuCategory::create(['name' => 'Soft Drinks & Juices', 'name_fr' => 'Soft & Jus', 'type' => 'bar', 'sort_order' => 5]);

        MenuItem::create(['menu_category_id' => $cocktails->id, 'name' => 'Rirenga Sunset', 'description' => 'Passion fruit, rum, lime, hibiscus syrup', 'price' => 9.00]);
        MenuItem::create(['menu_category_id' => $cocktails->id, 'name' => 'Forest Gin & Tonic', 'description' => 'Premium gin, tonic, cucumber, herbs', 'price' => 8.00]);
        MenuItem::create(['menu_category_id' => $cocktails->id, 'name' => 'Kigali Mule', 'description' => 'Vodka, ginger beer, lime, mint', 'price' => 8.50]);
        MenuItem::create(['menu_category_id' => $mocktails->id, 'name' => 'Green Valley', 'description' => 'Cucumber, mint, lime, sparkling water', 'price' => 5.00]);
        MenuItem::create(['menu_category_id' => $mocktails->id, 'name' => 'Mango Sunrise', 'description' => 'Mango, passion fruit, grenadine', 'price' => 5.00]);
        MenuItem::create(['menu_category_id' => $beers->id, 'name' => 'Primus (Rwanda)', 'price' => 3.50]);
        MenuItem::create(['menu_category_id' => $beers->id, 'name' => 'Mutzig Premium', 'price' => 4.00]);
        MenuItem::create(['menu_category_id' => $wines->id, 'name' => 'House Red (glass)', 'price' => 6.00]);
        MenuItem::create(['menu_category_id' => $wines->id, 'name' => 'House White (glass)', 'price' => 6.00]);
        MenuItem::create(['menu_category_id' => $softs->id, 'name' => 'Fresh Passion Fruit Juice', 'price' => 3.00]);
        MenuItem::create(['menu_category_id' => $softs->id, 'name' => 'Mineral Water (500ml)', 'price' => 1.50]);

        // Bar events
        BarEvent::create([
            'title'         => 'Friday Jazz Night',
            'title_fr'      => 'Soirée Jazz du Vendredi',
            'description'   => 'Unwind with live jazz every Friday evening from 7pm. Enjoy cocktails under the stars.',
            'description_fr'=> 'Détendez-vous avec du jazz live chaque vendredi soir à partir de 19h.',
            'starts_at'     => now()->next('Friday')->setTime(19, 0),
            'ends_at'       => now()->next('Friday')->setTime(22, 0),
            'is_active'     => true,
        ]);
        BarEvent::create([
            'title'       => 'Sunday Sundowner',
            'title_fr'    => 'Apéro du Dimanche',
            'description' => 'Watch the sun set over the hills with curated cocktails and light bites.',
            'starts_at'   => now()->next('Sunday')->setTime(17, 0),
            'ends_at'     => now()->next('Sunday')->setTime(19, 30),
            'is_active'   => true,
        ]);

        // Bar promotions
        BarPromotion::create([
            'title'         => 'Happy Hour',
            'title_fr'      => 'Happy Hour',
            'description'   => '50% off all cocktails Monday–Thursday, 5pm–7pm.',
            'description_fr'=> '50% de réduction sur tous les cocktails du lundi au jeudi, 17h–19h.',
            'is_active'     => true,
        ]);
        BarPromotion::create([
            'title'       => 'Couples Special',
            'title_fr'    => 'Spécial Couples',
            'description' => 'Two cocktails + a cheese board for $20. Available all week.',
            'is_active'   => true,
        ]);

        // Blog posts
        BlogPost::create([
            'user_id'      => $directorUser->id,
            'title'        => 'Welcome to Rirenga Eco-lodge',
            'title_fr'     => 'Bienvenue à Rirenga Eco-lodge',
            'slug'         => 'welcome-to-rirenga-eco-lodge',
            'excerpt'      => 'We are thrilled to open our doors and welcome guests to our eco-friendly sanctuary in Rwanda.',
            'excerpt_fr'   => "Nous sommes ravis d'ouvrir nos portes et d'accueillir nos hôtes.",
            'body'         => '<p>Rirenga Eco-lodge is nestled in the lush hills of Rwanda, offering a unique blend of nature immersion, warm Rwandan hospitality, and sustainable luxury. Our five self-contained rooms look out over forests and valleys, while our restaurant and bar celebrate the best of local produce.</p>',
            'body_fr'      => "<p>Rirenga Eco-lodge est niché dans les collines luxuriantes du Rwanda, offrant un mélange unique d'immersion dans la nature et de luxe durable.</p>",
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);
        BlogPost::create([
            'user_id'      => $managerUser->id,
            'title'        => 'Top 5 Hiking Trails Near Rirenga',
            'slug'         => 'top-5-hiking-trails-near-rirenga',
            'excerpt'      => 'Discover the breathtaking trails that start right at our doorstep.',
            'body'         => '<p>Rwanda is blessed with incredible natural scenery. Here are five trails accessible directly from Rirenga Eco-lodge.</p><ol><li><strong>Forest Loop Trail</strong> (2km, easy)</li><li><strong>Ridge View Trail</strong> (5km, moderate)</li><li><strong>Waterfall Hike</strong> (8km, moderate)</li><li><strong>Summit Trail</strong> (12km, challenging)</li><li><strong>Village Walk</strong> (4km, easy — cultural route)</li></ol>',
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);

        // Career positions
        CareerPosition::create([
            'title'        => 'Front Desk Officer',
            'department'   => 'Reception',
            'type'         => 'full_time',
            'description'  => 'Manage guest check-in/check-out, reservations, and concierge services.',
            'requirements' => "• Fluent English and French\n• Hospitality experience preferred\n• Warm, professional manner",
            'is_active'    => true,
        ]);
        CareerPosition::create([
            'title'        => 'Chef de Partie',
            'department'   => 'Kitchen',
            'type'         => 'full_time',
            'description'  => 'Prepare and present high-quality dishes for our restaurant.',
            'requirements' => "• Culinary training or equivalent experience\n• Knowledge of Rwandan and international cuisine",
            'is_active'    => true,
        ]);

        // Inventory items
        foreach ([
            ['name' => 'Bed Linen (sets)', 'category' => 'linen', 'unit' => 'sets', 'quantity' => 25, 'low_stock_threshold' => 10],
            ['name' => 'Towels', 'category' => 'linen', 'unit' => 'pcs', 'quantity' => 40, 'low_stock_threshold' => 15],
            ['name' => 'Primus Beer (crates)', 'category' => 'bar', 'unit' => 'crates', 'quantity' => 8, 'low_stock_threshold' => 3],
            ['name' => 'Mineral Water (cartons)', 'category' => 'bar', 'unit' => 'cartons', 'quantity' => 12, 'low_stock_threshold' => 5],
            ['name' => 'Cooking Oil (L)', 'category' => 'food', 'unit' => 'L', 'quantity' => 20, 'low_stock_threshold' => 5],
            ['name' => 'Rice (kg)', 'category' => 'food', 'unit' => 'kg', 'quantity' => 50, 'low_stock_threshold' => 10],
            ['name' => 'Toilet Paper (rolls)', 'category' => 'cleaning', 'unit' => 'rolls', 'quantity' => 60, 'low_stock_threshold' => 20],
            ['name' => 'Hand Soap (bars)', 'category' => 'cleaning', 'unit' => 'bars', 'quantity' => 4, 'low_stock_threshold' => 10],
        ] as $item) {
            InventoryItem::create($item);
        }
    }
}
