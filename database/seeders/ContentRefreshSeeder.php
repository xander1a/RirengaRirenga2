<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

/**
 * Idempotent content update for the Kigali / sunset repositioning.
 *
 * Safe to run on a live database: it only UPDATES existing records
 * (blog posts + room amenities) and never creates duplicates.
 * Uses no factories/faker, so it runs under `composer install --no-dev`.
 *
 *   php artisan db:seed --class=ContentRefreshSeeder --force
 */
class ContentRefreshSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hiking blog post -> Sunset blog post
        $hike = BlogPost::where('slug', 'top-5-hiking-trails-near-rirenga')
            ->orWhere('title', 'Top 5 Hiking Trails Near Rirenga')
            ->first();

        if ($hike) {
            $hike->title   = 'The Best Sunset Spot in Kigali';
            $hike->slug    = 'the-best-sunset-spot-in-kigali';
            $hike->excerpt = 'Why the end of the day is the best time to be at Rirenga.';
            $hike->body    = '<p>There is no better way to close a day in Kigali than from our west-facing terrace. As the sun dips over the hills, the city glows gold and the evening air cools. Here is how to make the most of it at Rirenga Eco-lodge.</p><ol><li><strong>Arrive early</strong> — the light starts to turn around 5:30pm.</li><li><strong>Order a Rirenga Sunset</strong> — our signature cocktail, made for the moment.</li><li><strong>Grab the terrace lounge</strong> — the best west-facing seats in the house.</li><li><strong>Stay for dinner</strong> — our farm-to-table menu follows the sunset.</li><li><strong>Sunday Sundowner</strong> — join our weekly golden-hour session.</li></ol>';
            $hike->save();
            $this->command?->info('Updated blog post: The Best Sunset Spot in Kigali');
        }

        // 2. Welcome blog post -> Kigali wording
        $welcome = BlogPost::where('slug', 'welcome-to-rirenga-eco-lodge')
            ->orWhere('title', 'Welcome to Rirenga Eco-lodge')
            ->first();

        if ($welcome) {
            $welcome->excerpt    = 'We are thrilled to open our doors and welcome guests to our modern eco-lodge in Kigali.';
            $welcome->excerpt_fr = "Nous sommes ravis d'ouvrir nos portes et d'accueillir nos hôtes à Kigali.";
            $welcome->body       = '<p>Rirenga Eco-lodge sits on the green hills of Kigali, offering a modern blend of contemporary design, warm Rwandan hospitality, and sustainable comfort. Our five self-contained rooms look out over the city, while our restaurant, bar, and sunset terrace celebrate the best of local produce.</p>';
            $welcome->body_fr    = "<p>Rirenga Eco-lodge est situé sur les collines verdoyantes de Kigali, offrant un mélange moderne de design contemporain, d'hospitalité rwandaise chaleureuse et de confort durable.</p>";
            $welcome->save();
            $this->command?->info('Updated blog post: Welcome (Kigali wording)');
        }

        // 3. Room amenities: Hiking Access -> Sunset View, Forest View -> City View
        $rooms = [
            'DBL'  => ['Dinner & Breakfast Included', 'Private Terrace', 'Ensuite Bathroom', 'Sunset View', 'Free WiFi', 'City View'],
            'TWIN' => ['Dinner & Breakfast Included', 'Garden View', 'Ensuite Bathroom', 'Sunset View', 'Free WiFi'],
            'SGL'  => ['Dinner & Breakfast Included', 'Ensuite Bathroom', 'Sunset View', 'Free WiFi'],
        ];

        foreach ($rooms as $code => $amenities) {
            $rt = RoomType::where('code', $code)->first();
            if (! $rt) {
                continue;
            }
            $rt->amenities = $amenities;
            if ($code === 'DBL') {
                $rt->description = str_replace('overlooking the forest', 'overlooking the city', $rt->description);
            }
            $rt->save();
            $this->command?->info("Updated room amenities: {$code}");
        }
    }
}
