@extends('layouts.app')
@section('title',$destination->name.' — India Uncaged')
@section('content')
<section class="detail-hero" style="{{ $destination->hero_image ? "background-image:url('".e($destination->hero_image)."')" : '' }}"><div><p class="eyebrow">{{ $destination->state_region }}</p><h1>{{ $destination->name }}</h1><p>{{ $destination->tagline }}</p></div></section>
<section class="detail-content">
<div class="detail-main"><p class="eyebrow">ABOUT</p><div class="rich-copy">{!! nl2br(e($destination->about)) !!}</div>
@if($destination->why_visit)<p class="eyebrow">WHY VISIT</p><div class="rich-copy">{!! nl2br(e($destination->why_visit)) !!}</div>@endif
@if($destination->wildlife)<div class="detail-block"><p class="eyebrow">WILDLIFE</p><div class="tag-list">@foreach($destination->wildlife as $item)<span>{{ $item }}</span>@endforeach</div></div>@endif
@if($destination->best_season)<div class="detail-block"><p class="eyebrow">BEST SEASON</p><h2>{{ $destination->best_season }}</h2><p>{{ $destination->best_season_description }}</p></div>@endif
@if($destination->experiences)<div class="detail-block"><p class="eyebrow">EXPERIENCES</p><div class="tag-list">@foreach($destination->experiences as $item)<span>{{ $item }}</span>@endforeach</div></div>@endif
</div>
<aside class="detail-aside"><p class="eyebrow">PLAN THIS TRIP</p><p>Tell us what you're looking for and we'll shape the journey around this destination.</p><a class="button button--primary" href="{{ route('plan',['destination'=>$destination->slug]) }}">PLAN THIS TRIP</a><a class="button" target="_blank" rel="noopener" href="https://wa.me/{{ config('indiauncaged.whatsapp_number') }}?text={{ urlencode("Hi, I'm interested in a wildlife journey to ".$destination->name." and would like to have more details.") }}">ENQUIRE ON WHATSAPP</a></aside>
</section>
<section class="related-section"><div class="section-heading"><p class="eyebrow">UPCOMING JOURNEYS</p><h2>Trips in {{ $destination->name }}</h2></div>
<div class="mini-tour-grid">@forelse($destination->tours as $tour) @foreach($tour->dates as $date)<a class="mini-tour-card" href="{{ route('tours.show',$tour) }}"><strong>{{ $tour->name }}</strong><span>{{ $date->start_date->format('d M Y') }} — {{ $date->end_date->format('d M Y') }}</span></a>@endforeach @empty<div class="empty-state"><p>No published departures yet.</p><a class="button" href="{{ route('plan',['destination'=>$destination->slug]) }}">Plan a private journey</a></div>@endforelse</div></section>
@endsection