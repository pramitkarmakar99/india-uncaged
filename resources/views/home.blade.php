@extends('layouts.app')
@section('title', 'India Uncaged — Wildlife Expeditions')
@section('content')
<section class="hero">
    <div class="hero-copy">
        <p class="eyebrow">INDIA UNCAGED</p>
        <h1>Where the wild still writes the story.</h1>
        <p>Premium wildlife journeys shaped by field knowledge, photography and responsible travel.</p>
        <a class="button" href="{{ route('plan') }}">PLAN YOUR JOURNEY</a>
    </div>
</section>
<section class="placeholder-section">
    <p class="eyebrow">SHOT IN THE WILD</p>
    <h2>Your photography will live here.</h2>
</section>
@endsection
