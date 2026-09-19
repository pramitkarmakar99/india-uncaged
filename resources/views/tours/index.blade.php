@extends('layouts.app')
@section('title','Upcoming Tours — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">UPCOMING TOURS</p><h1>Enter the wild.</h1><p>Explore published departures and find the journey that fits you.</p></section>
<section class="tour-filters"><form method="GET" action="{{ route('tours') }}"><div class="tour-filters__grid">
<label>Destination<select name="destination"><option value="">All destinations</option>@foreach($destinations as $destination)<option value="{{ $destination->id }}" @selected(request('destination')==$destination->id)>{{ $destination->name }}</option>@endforeach</select></label>
<label>Month<select name="month"><option value="">Any month</option>@foreach(range(1,12) as $m)<option value="{{ $m }}" @selected((string)request('month')===(string)$m)>{{ DateTime::createFromFormat('!m',$m)->format('F') }}</option>@endforeach</select></label>
<label>Wildlife<select name="wildlife"><option value="">Any wildlife</option>@foreach($wildlife as $item)<option value="{{ $item }}" @selected(request('wildlife')===$item)>{{ $item }}</option>@endforeach</select></label>
<label>Experience<select name="experience"><option value="">Any experience</option>@foreach($experiences as $item)<option value="{{ $item }}" @selected(request('experience')===$item)>{{ $item }}</option>@endforeach</select></label>
<label>Sort<select name="sort"><option value="soonest" @selected(request('sort','soonest')==='soonest')>Soonest departure</option><option value="price" @selected(request('sort')==='price')>Price</option><option value="destination" @selected(request('sort')==='destination')>Destination</option></select></label>
</div><div class="filter-actions"><button class="button button--primary">APPLY FILTERS</button><a class="button" href="{{ route('tours') }}">RESET</a></div></form></section>
<section class="tour-list">
@forelse($dates as $date)<article class="tour-card"><div class="tour-card__image" style="{{ $date->tour?->hero_image ? "background-image:url('".e($date->tour->hero_image)."')" : '' }}"></div><div class="tour-card__body"><p class="eyebrow">{{ $date->tour?->destination?->name }}</p><h2>{{ $date->tour?->name }}</h2><p>{{ $date->tour?->short_description }}</p><div class="tour-card__meta"><span>{{ $date->start_date->format('d M Y') }} — {{ $date->end_date->format('d M Y') }}</span><span>{{ $date->price !== null ? '₹'.number_format($date->price,0) : 'Price on enquiry' }}</span></div>@if($date->available_seats !== null)<p class="field-help">{{ $date->available_seats }} seats available</p>@endif<a class="button" href="{{ route('tour',$date->tour) }}">VIEW TOUR</a></div></article>
@empty<div class="empty-state"><p class="eyebrow">THE CALENDAR IS QUIET</p><h2>No departures match your filters.</h2><p>Try another combination or plan a private journey.</p><a class="button button--primary" href="{{ route('plan') }}">PLAN YOUR JOURNEY</a></div>@endforelse
</section></section>
@endsection