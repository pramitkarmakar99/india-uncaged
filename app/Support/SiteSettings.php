<?php

namespace App\Support;

use App\Models\SiteSetting;

class SiteSettings
{
    public static function get(string $key, ?string $default=null): ?string
    {
        $fallbacks=[
            'whatsapp_number'=>config('indiauncaged.whatsapp'),
            'phone_primary'=>config('indiauncaged.phone'),
            'phone_secondary'=>config('indiauncaged.phone_secondary'),
            'contact_email'=>config('indiauncaged.email'),
            'instagram_handle'=>config('indiauncaged.instagram_handle'),
        ];
        return SiteSetting::value($key, $fallbacks[$key] ?? $default);
    }
}
