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
        'contact'=>['whatsapp_number','phone_primary','phone_secondary','contact_email','instagram_handle','instagram_url','facebook_url','youtube_url','google_maps_url'],
        'branding'=>['horizontal_logo','square_logo','favicon','social_preview','default_seo_image'],
        'hero'=>['hero_video','hero_poster','hero_headline','hero_subheadline','hero_primary_label','hero_primary_url','hero_secondary_label','hero_secondary_url'],
        'social'=>['instagram_embed_code'],
        'about'=>['about_headline','about_intro','about_story','about_approach','about_responsible_headline','about_responsible_text','about_team_headline','team_1_name','team_1_role','team_1_bio','team_1_image','team_2_name','team_2_role','team_2_bio','team_2_image','team_3_name','team_3_role','team_3_bio','team_3_image'],
    ];

    public function edit(): View
    {
        $defaults=[
            'whatsapp_number'=>config('indiauncaged.whatsapp_number'),
            'phone_primary'=>config('indiauncaged.phone_primary'),
            'phone_secondary'=>config('indiauncaged.phone_secondary'),
            'contact_email'=>config('indiauncaged.contact_email'),
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

        foreach (['instagram_url','facebook_url','youtube_url','google_maps_url','hero_video','hero_poster','horizontal_logo','square_logo','favicon','social_preview','default_seo_image','team_1_image','team_2_image','team_3_image'] as $key) {
            $rules[$key][] = 'max:2048';
            $rules[$key][] = 'regex:/^(https?:\\/\\/|\\/storage\\/)[^\\s]+$/i';
        }

        foreach (['hero_primary_url','hero_secondary_url'] as $key) {
            $rules[$key][] = 'max:2048';
            $rules[$key][] = 'regex:/^(https?:\\/\\/|\\/[^\\/]|[^\\s]+$)/i';
        }

        $rules['contact_email'] = ['nullable','email','max:255'];
        $rules['whatsapp_number'] = ['nullable','string','max:30','regex:/^[+0-9 ()-]+$/'];
        $rules['phone_primary'] = ['nullable','string','max:30','regex:/^[+0-9 ()-]+$/'];
        $rules['phone_secondary'] = ['nullable','string','max:30','regex:/^[+0-9 ()-]+$/'];
        $data=$request->validate($rules);
        foreach($keys as $key) SiteSetting::updateOrCreate(['key'=>$key],['value'=>$data[$key] ?? null]);
        return back()->with('success','Site settings updated.');
    }

    public static function groups(): array { return (new static)->groups; }
}
