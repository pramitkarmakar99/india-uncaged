<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'India Uncaged')</title>
@php($site=app(\App\Support\SiteSettings::class))
    <meta name="description" content="@yield('description', 'Premium wildlife journeys across India.')">
    @vite(['resources/css/app.css'])
</head>
<body>
<header class="site-header">
    <a class="brand" href="{{ route('home') }}">{{ $site::get('horizontal_logo') ? '' : 'INDIA UNCAGED' }}@if($site::get('horizontal_logo'))<img src="{{ $site::get('horizontal_logo') }}" alt="India Uncaged" class="site-logo">@endif</a>
    <nav aria-label="Primary navigation">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('destinations') }}">Destinations</a>
        <a href="{{ route('tours') }}">Upcoming Tours</a>
        <a href="{{ route('gallery') }}">Gallery</a>
        <a href="{{ route('journal') }}">Journal</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('contact') }}">Contact</a>
    </nav>
    <a class="nav-cta" href="{{ route('plan') }}">PLAN YOUR JOURNEY</a>
</header>

<main>@yield('content')</main>

<footer class="site-footer">
    <div><strong>India Uncaged</strong><br><span>Wildlife journeys, thoughtfully made.</span></div>
    <div>{{ config('indiauncaged.contact_email') }}</div>
</footer>

<div class="contact-widget" aria-label="India Uncaged contact options">
    <a class="contact-widget__whatsapp" href="https://wa.me/{{ config('indiauncaged.whatsapp_number') }}" target="_blank" rel="noopener">WhatsApp</a>
    <div class="contact-widget__panel">
        <a href="tel:+91{{ config('indiauncaged.phone_primary') }}">Call {{ config('indiauncaged.phone_primary') }}</a>
        <a href="tel:+91{{ $site::get('phone_secondary') }}">Call {{ config('indiauncaged.phone_secondary') }}</a>
        <a href="mailto:{{ config('indiauncaged.contact_email') }}">Email us</a>
        <a href="https://instagram.com/{{ ltrim(config('indiauncaged.instagram_handle'), '@') }}" target="_blank" rel="noopener">Instagram</a>
    </div>
</div>
</body>
</html>
