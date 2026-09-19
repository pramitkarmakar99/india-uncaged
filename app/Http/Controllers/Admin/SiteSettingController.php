<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private array $groups = [
        'contact'=>['whatsapp_number','phone_primary','phone_secondary','contact_email','instagram_handle','instagram_url','facebook_url','youtube_url'],
        'branding'=>['horizontal_logo','square_logo','favicon','social_preview','default_seo_image'],
        'hero'=>['hero_video','hero_poster','hero_headline','hero_subheadline','hero_primary_label','hero_primary_url','hero_secondary_label','hero_secondary_url'],
        'social'=>['instagram_embed_code'],
    ];

    public function edit(): View
    {
        $defaults=[
            'whatsapp_number'=>config('indiauncaged.whatsapp'),
            'phone_primary'=>config('indiauncaged.phone'),
            'phone_secondary'=>config('indiauncaged.phone_secondary'),
            'contact_email'=>config('indiauncaged.email'),
            'instagram_handle'=>config('indiauncaged.instagram_handle'),
        ];
        $settings=SiteSetting::pluck('value','key')->all();
        foreach($defaults as $key=>$value) if(!array_key_exists($key,$settings)) $settings[$key]=$value;
        return view('admin.settings.edit',compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $keys=array_merge(...array_values($this->groups));
        $rules=[];
        foreach($keys as $key) $rules[$key]=['nullable','string','max:10000'];
        $data=$request->validate($rules);
        foreach($keys as $key) SiteSetting::updateOrCreate(['key'=>$key],['value'=>$data[$key] ?? null]);
        return back()->with('success','Site settings updated.');
    }

    public static function groups(): array { return (new static)->groups; }
}
