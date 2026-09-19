@extends('layouts.app')
@section('title','Upcoming Tours — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">UPCOMING TOURS</p><h1>Enter the wild.</h1><p>Actual published departures from the India Uncaged calendar.</p></section>
<section class="tour-list">
@forelse($dates as $date)
<article class="tour-card">
<div class="tour-card__image" style="{{ $date->tour?->hero_image ? "background-image:url('".e($date->tour->hero_image)."')" : '' }}"></div>
<div class="tour-card__body">
<p class="eyebrow">{{ $date->tour?->destination?->name }}</p>
<h2>{{ $date->tour?->name }}</h2>
<p>{{ $date->tour?->short_description }}</p>
<div class="tour-card__meta"><span>{{ $date->start_date->format('d M Y') }} — {{ $date->end_date->format('d M Y') }}</span><span>{{ $date->price !== null ? '₹'.number_format($date->price,0) : 'Price on enquiry' }}</span></div>
@if($date->available_seats !== null)<p class="field-help">{{ $date->available_seats }} seats available</p>@endif
<a class="button" href="{{ route('plan') }}">ENQUIRE ABOUT THIS TOUR</a>
</div>
</article>
@empty
<div class="empty-state"><p class="eyebrow">THE CALENDAR IS QUIET</p><h2>No upcoming departures yet.</h2><p>Tell us where you want to go and we'll help shape a private journey around it.</p><a class="button button--primary" href="{{ route('plan') }}">PLAN YOUR JOURNEY</a></div>
@endforelse
</section>
@endsection
