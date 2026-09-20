<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php($site=app(\\App\\Support\\SiteSettings::class))
    <title>@yield('title', 'India Uncaged')</title>
    <meta name="robots" content="@yield('robots', 'index,follow')">
    <meta name="description" content="@yield('description', 'Premium wildlife journeys across India.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    @if($site::get('favicon'))<link rel="icon" href="{{ $site::get('favicon') }}">@endif
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')) ?: 'India Uncaged')">
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('description')) ?: 'Premium wildlife journeys across India.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    @if($site::get('social_preview') ?: $site::get('default_seo_image'))<meta property="og:image" content="{{ $site::get('social_preview') ?: $site::get('default_seo_image') }}">@endif
    <meta name="twitter:card" content="summary_large_image">
    @if($site::get('social_preview') ?: $site::get('default_seo_image'))<meta name="twitter:image" content="{{ $site::get('social_preview') ?: $site::get('default_seo_image') }}">@endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="site-header" data-site-header>
    <a class="mobile-menu-toggle" href="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false">MENU</a>
    <a class="brand" href="{{ route('home') }}">
        @if($site::get('horizontal_logo'))<img src="{{ $site::get('horizontal_logo') }}" alt="India Uncaged" class="site-logo">@else INDIA UNCAGED @endif
    </a>
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
    <div class="mobile-menu" id="mobile-menu" hidden>
        <div class="mobile-menu__inner">
            <nav aria-label="Mobile navigation">
                <a href="{{ route('home') }}">Home</a><a href="{{ route('destinations') }}">Destinations</a><a href="{{ route('tours') }}">Upcoming Tours</a><a href="{{ route('gallery') }}">Gallery</a><a href="{{ route('journal') }}">Journal</a><a href="{{ route('about') }}">About Us</a><a href="{{ route('contact') }}">Contact</a>
            </nav>
            <a class="button button--primary" href="{{ route('plan') }}">PLAN YOUR JOURNEY</a>
            <a class="mobile-menu__whatsapp" href="https://wa.me/{{ preg_replace('/\\D/','',$site::get('whatsapp_number')) }}" target="_blank" rel="noopener">WHATSAPP</a>
        </div>
    </div>
</header>

<main>@yield('content')</main>

<footer class="site-footer">
    <div>@if($site::get('square_logo'))<img src="{{ $site::get('square_logo') }}" alt="India Uncaged" class="footer-logo">@else<strong>India Uncaged</strong>@endif<br><span>Wildlife journeys, thoughtfully made.</span></div>
    <div>{{ $site::get('contact_email') }}</div>
</footer>

<div class="contact-widget" aria-label="India Uncaged contact options">
    <a class="contact-widget__whatsapp" href="https://wa.me/{{ preg_replace('/\\D/','',$site::get('whatsapp_number')) }}" target="_blank" rel="noopener">WhatsApp</a>
    <div class="contact-widget__panel">
        <a href="tel:{{ preg_replace('/\\D/','',$site::get('phone_primary')) }}">Call {{ $site::get('phone_primary') }}</a>
        <a href="tel:{{ preg_replace('/\\D/','',$site::get('phone_secondary')) }}">Call {{ $site::get('phone_secondary') }}</a>
        <a href="mailto:{{ $site::get('contact_email') }}">Email us</a>
        <a href="{{ $site::get('instagram_url','https://instagram.com/'.ltrim($site::get('instagram_handle'),'@')) }}" target="_blank" rel="noopener">Instagram</a>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded",()=>{const h=document.querySelector("[data-site-header]"),b=document.querySelector(".mobile-menu-toggle"),m=document.getElementById("mobile-menu");const sync=()=>h.classList.toggle("is-scrolled",window.scrollY>24);sync();window.addEventListener("scroll",sync,{passive:true});b?.addEventListener("click",e=>{e.preventDefault();const open=!m.hasAttribute("hidden");if(open){m.setAttribute("hidden","");b.setAttribute("aria-expanded","false")}else{m.removeAttribute("hidden");b.setAttribute("aria-expanded","true")}});m?.querySelectorAll("a").forEach(a=>a.addEventListener("click",()=>{m.setAttribute("hidden","");b.setAttribute("aria-expanded","false")}));});
</script>
</body>
</html>