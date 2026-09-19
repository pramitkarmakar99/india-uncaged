<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'India Uncaged')</title>
    <meta name="description" content="@yield('description', 'Premium wildlife journeys across India.')">
    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}">INDIA UNCAGED</a>
        <nav>
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
        <div>India Uncaged</div>
        <div>Crafting journeys into the wild.</div>
    </footer>

    <a class="whatsapp-float"
       href="https://wa.me/{{ config('indiauncaged.whatsapp_number') }}"
       target="_blank"
       rel="noopener"
       aria-label="Chat with India Uncaged on WhatsApp">WhatsApp</a>
</body>
</html>
