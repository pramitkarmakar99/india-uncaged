@extends('layouts.app')
@section('title','Contact — India Uncaged')
@section('content')
@php($site=app(\App\Support\SiteSettings::class))
<section class="page-intro"><p class="eyebrow">CONTACT</p><h1>Start planning your journey.</h1><p>For a quick conversation, WhatsApp us. For a detailed request, use the planning form.</p></section>
<section class="contact-layout">
<div><p class="eyebrow">DIRECT</p><div class="contact-list"><a href="https://wa.me/{{ preg_replace('/\D/','',$site::get('whatsapp_number')) }}" target="_blank" rel="noopener">WhatsApp · {{ $site::get('whatsapp_number') }}</a><a href="tel:{{ preg_replace('/\D/','',$site::get('phone_primary')) }}">{{ $site::get('phone_primary') }}</a><a href="tel:{{ preg_replace('/\D/','',$site::get('phone_secondary')) }}">{{ $site::get('phone_secondary') }}</a><a href="mailto:{{ $site::get('contact_email') }}">{{ $site::get('contact_email') }}</a><a href="{{ $site::get('instagram_url','https://instagram.com/'.ltrim($site::get('instagram_handle'),'@')) }}" target="_blank" rel="noopener">{{ $site::get('instagram_handle') }}</a></div>
@if($site::get('google_maps_url'))<div class="contact-map-card"><p class="eyebrow">FIND US</p><h2>Visit India Uncaged</h2><p>Open our location in Google Maps for directions.</p><a class="button" href="{{ $site::get('google_maps_url') }}" target="_blank" rel="noopener">OPEN IN GOOGLE MAPS</a></div>@endif
</div>
<div><p class="eyebrow">ENQUIRE</p>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('contact.store') }}" class="public-form">@csrf<input type="hidden" name="source" value="contact"><div class="form-grid form-grid--2"><label>Name *<input name="name" value="{{ old('name') }}" required></label><label>WhatsApp Number *<input name="whatsapp" value="{{ old('whatsapp') }}" required></label><label>Email<input type="email" name="email" value="{{ old('email') }}"></label><label>Destination<input name="destination" value="{{ old('destination') }}"></label></div><label>Message<textarea name="message" rows="7">{{ old('message') }}</textarea></label><button class="button button--primary">SEND ENQUIRY</button></form></div>
</section>
@endsection