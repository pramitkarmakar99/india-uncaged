@extends('layouts.app')
@section('title','Destinations — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">DESTINATIONS</p><h1>Where the wild takes you.</h1><p>Explore the landscapes and wildlife regions that shape India Uncaged journeys.</p></section>
<section class="destination-grid">
@forelse($destinations as $destination)
<a class="destination-card" href="{{ route('destinations.show',$destination) }}">
<div class="destination-card__image" style="{{ $destination->hero_image ? "background-image:url('".e($destination->hero_image)."')" : '' }}"></div>
<div class="destination-card__body"><p class="eyebrow">{{ $destination->state_region }}</p><h2>{{ $destination->name }}</h2><p>{{ $destination->tagline }}</p><span>{{ $destination->tours_count }} {{ Str::plural('journey',$destination->tours_count) }}</span></div>
</a>
@empty
<div class="empty-state"><p class="eyebrow">DESTINATIONS</p><h2>The map is still being written.</h2><p>Our destination collection will appear here as journeys are added.</p></div>
@endforelse
</section>
@endsection