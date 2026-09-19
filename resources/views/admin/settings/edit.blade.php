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
<div class="form-section"><p class="eyebrow">Instagram</p><label>Instagram embed code<textarea name="instagram_embed_code" rows="8" placeholder="Paste the trusted Instagram/widget embed code here.">{{ old('instagram_embed_code',$settings['instagram_embed_code'] ?? '') }}</textarea></label></div>
<div class="admin-actions"><button class="button button--primary">Save settings</button></div>
</form></section>
@endsection