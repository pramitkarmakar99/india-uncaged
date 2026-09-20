@extends('layouts.app')
@section('content')
<section class="admin-page"><div class="admin-header"><div><p class="eyebrow">CMS / Site Settings</p><h1>Site Settings</h1><p>Control global contact, branding, social and homepage hero content.</p></div></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.settings.update') }}" class="admin-form">@csrf
<div class="form-section"><p class="eyebrow">Contact</p><div class="form-grid form-grid--2">
<label>WhatsApp number<input name="whatsapp_number" value="{{ old('whatsapp_number',$settings['whatsapp_number'] ?? '') }}"></label>
<label>Primary phone<input name="phone_primary" value="{{ old('phone_primary',$settings['phone_primary'] ?? '') }}"></label>
<label>Secondary phone<input name="phone_secondary" value="{{ old('phone_secondary',$settings['phone_secondary'] ?? '') }}"></label>
<label>Email<input type="email" name="contact_email" value="{{ old('contact_email',$settings['contact_email'] ?? '') }}"></label>
<label>Instagram handle<input name="instagram_handle" value="{{ old('instagram_handle',$settings['instagram_handle'] ?? '') }}"></label>
<label>Instagram URL<input name="instagram_url" value="{{ old('instagram_url',$settings['instagram_url'] ?? '') }}"></label>
<label>Facebook URL<input name="facebook_url" value="{{ old('facebook_url',$settings['facebook_url'] ?? '') }}"></label>
<label>YouTube URL<input name="youtube_url" value="{{ old('youtube_url',$settings['youtube_url'] ?? '') }}"></label>
<label>Google Maps link<input name="google_maps_url" value="{{ old('google_maps_url',$settings['google_maps_url'] ?? '') }}"></label>
</div></div>
<div class="form-section"><p class="eyebrow">Branding</p><div class="form-grid form-grid--2">
<label>Horizontal logo path / URL<input name="horizontal_logo" value="{{ old('horizontal_logo',$settings['horizontal_logo'] ?? '') }}"></label>
<label>Square logo path / URL<input name="square_logo" value="{{ old('square_logo',$settings['square_logo'] ?? '') }}"></label>
<label>Favicon path / URL<input name="favicon" value="{{ old('favicon',$settings['favicon'] ?? '') }}"></label>
<label>Social preview image<input name="social_preview" value="{{ old('social_preview',$settings['social_preview'] ?? '') }}"></label>
<label>Default SEO image<input name="default_seo_image" value="{{ old('default_seo_image',$settings['default_seo_image'] ?? '') }}"></label>
</div></div>
<div class="form-section"><p class="eyebrow">Homepage Hero</p><div class="form-grid form-grid--2">
<label>Hero video path / URL<input name="hero_video" value="{{ old('hero_video',$settings['hero_video'] ?? '') }}"></label>
<label>Hero poster path / URL<input name="hero_poster" value="{{ old('hero_poster',$settings['hero_poster'] ?? '') }}"></label>
<label>Hero headline<input name="hero_headline" value="{{ old('hero_headline',$settings['hero_headline'] ?? '') }}"></label>
<label>Hero subheadline<input name="hero_subheadline" value="{{ old('hero_subheadline',$settings['hero_subheadline'] ?? '') }}"></label>
<label>Primary button label<input name="hero_primary_label" value="{{ old('hero_primary_label',$settings['hero_primary_label'] ?? '') }}"></label>
<label>Primary button URL<input name="hero_primary_url" value="{{ old('hero_primary_url',$settings['hero_primary_url'] ?? '') }}"></label>
<label>Secondary button label<input name="hero_secondary_label" value="{{ old('hero_secondary_label',$settings['hero_secondary_label'] ?? '') }}"></label>
<label>Secondary button URL<input name="hero_secondary_url" value="{{ old('hero_secondary_url',$settings['hero_secondary_url'] ?? '') }}"></label>
</div></div>
<div class="form-section"><p class="eyebrow">About Us</p><div class="form-grid form-grid--2">
<label>Headline<input name="about_headline" value="{{ old('about_headline',$settings['about_headline'] ?? '') }}"></label><label>Intro<input name="about_intro" value="{{ old('about_intro',$settings['about_intro'] ?? '') }}"></label>
<label>Team headline<input name="about_team_headline" value="{{ old('about_team_headline',$settings['about_team_headline'] ?? '') }}"></label><label>Responsible headline<input name="about_responsible_headline" value="{{ old('about_responsible_headline',$settings['about_responsible_headline'] ?? '') }}"></label>
</div><label>Our story<textarea name="about_story" rows="7">{{ old('about_story',$settings['about_story'] ?? '') }}</textarea></label><label>Our approach<textarea name="about_approach" rows="5">{{ old('about_approach',$settings['about_approach'] ?? '') }}</textarea></label><label>Responsible travel text<textarea name="about_responsible_text" rows="5">{{ old('about_responsible_text',$settings['about_responsible_text'] ?? '') }}</textarea></label>
<div class="team-settings"><p class="eyebrow">Team members</p>@foreach(range(1,3) as $i)<div class="form-grid form-grid--2"><label>Name {{ $i }}<input name="team_{{ $i }}_name" value="{{ old('team_'.$i.'_name',$settings['team_'.$i.'_name'] ?? '') }}"></label><label>Role<input name="team_{{ $i }}_role" value="{{ old('team_'.$i.'_role',$settings['team_'.$i.'_role'] ?? '') }}"></label><label>Image path / URL<input name="team_{{ $i }}_image" value="{{ old('team_'.$i.'_image',$settings['team_'.$i.'_image'] ?? '') }}"></label></div><label>Bio<textarea name="team_{{ $i }}_bio" rows="3">{{ old('team_'.$i.'_bio',$settings['team_'.$i.'_bio'] ?? '') }}</textarea></label>@endforeach</div></div><div class="form-section"><p class="eyebrow">Instagram</p><label>Instagram embed code<textarea name="instagram_embed_code" rows="8" placeholder="Paste the trusted Instagram/widget embed code here.">{{ old('instagram_embed_code',$settings['instagram_embed_code'] ?? '') }}</textarea></label></div>
<div class="admin-actions"><button class="button button--primary">Save settings</button></div>
</form></section>
@endsection