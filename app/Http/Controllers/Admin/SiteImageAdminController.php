<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteImageAdminController extends Controller
{
    /**
     * Every admin-editable image slot on the public website.
     * key => [label, where it appears, recommended size]
     */
    public const SLOTS = [
        'home_hero'       => ['Home — Hero banner', 'Full-screen background at the top of the home page', '1920×1080'],
        'story_1'         => ['Home — Our Story photo 1', 'Top-left photo in the Our Story grid', '800×800'],
        'story_2'         => ['Home — Our Story photo 2', 'Top-right photo in the Our Story grid', '800×800'],
        'story_3'         => ['Home — Our Story photo 3', 'Bottom-left photo in the Our Story grid', '800×800'],
        'story_4'         => ['Home — Our Story photo 4', 'Bottom-right photo in the Our Story grid', '800×800'],
        'offer_stay'      => ['Home — What We Offer: Accommodation', 'Photo beside the Accommodation text', '1200×800'],
        'offer_dining'    => ['Home — What We Offer: Food & Drinks', 'Photo beside the Food & Drinks text', '1200×800'],
        'offer_hiking'    => ['Home — What We Offer: Hiking', 'Photo beside the Hiking Experiences text', '1200×800'],
        'dining_2'        => ['Home — Dining photo', 'Second photo in the restaurant teaser', '800×1000'],
        'bar_1'           => ['Home — Bar photo', 'First photo in the bar teaser', '800×1000'],
        'rooms_hero'      => ['Rooms page — Header', 'Banner behind the Rooms page title', '1920×600'],
        'about_hero'      => ['About page — Header', 'Banner behind the About page title', '1920×600'],
        'restaurant_hero' => ['Restaurant page — Header', 'Banner behind the Restaurant page title', '1920×600'],
        'bar_hero'        => ['Bar page — Header', 'Banner behind the Bar page title', '1920×600'],
        'gallery_hero'    => ['Gallery page — Header', 'Banner behind the Gallery page title', '1920×600'],
        'blog_hero'       => ['Blog page — Header', 'Banner behind the Blog page title', '1920×600'],
        'contact_hero'    => ['Contact page — Header', 'Banner behind the Contact page title', '1920×600'],
        'booking_hero'    => ['Booking page — Header', 'Banner behind the Book Your Stay title', '1920×600'],
        'services_hero'   => ['Services page — Header', 'Banner behind the Services page title', '1920×600'],
        'careers_hero'    => ['Careers page — Header', 'Banner behind the Careers page title', '1920×600'],
    ];

    public function index()
    {
        $settings = SiteSetting::all_cached();

        return view('admin.site-images.index', [
            'slots' => self::SLOTS,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request, string $slot)
    {
        abort_unless(array_key_exists($slot, self::SLOTS), 404);

        $request->validate(['image' => ['required', 'image', 'max:6144']]);

        $old = SiteSetting::get('image.' . $slot);
        if ($old) {
            Storage::disk('public')->delete($old);
        }

        $path = store_image($request->file('image'), 'site');
        SiteSetting::set('image.' . $slot, $path);

        return redirect()->back()->with('success', self::SLOTS[$slot][0] . ' updated.');
    }

    public function destroy(string $slot)
    {
        abort_unless(array_key_exists($slot, self::SLOTS), 404);

        $old = SiteSetting::get('image.' . $slot);
        if ($old) {
            Storage::disk('public')->delete($old);
        }
        SiteSetting::set('image.' . $slot, null);

        return redirect()->back()->with('success', self::SLOTS[$slot][0] . ' removed — the default look is back.');
    }
}
