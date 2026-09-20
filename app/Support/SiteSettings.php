<?php

namespace App\Support;

use App\Models\SiteSetting;

class SiteSettings
{
    public static function get(string $key, ?string $default=null): ?string
    {
        $fallbacks=[
            'whatsapp_number'=>config('indiauncaged.whatsapp_number'),
            'phone_primary'=>config('indiauncaged.phone_primary'),
            'phone_secondary'=>config('indiauncaged.phone_secondary'),
            'contact_email'=>config('indiauncaged.contact_email'),
            'instagram_handle'=>config('indiauncaged.instagram_handle'),
            'google_maps_url'=>'https://maps.app.goo.gl/BpaAD8p68uyY4e9i8',
        ];
        return SiteSetting::value($key, $fallbacks[$key] ?? $default);
    }
}
