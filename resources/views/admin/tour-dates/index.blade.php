@extends('layouts.app')
@section('content')
<section class="admin-page">
<div class="admin-header"><div><p class="eyebrow">CMS / Departures</p><h1>Tour Dates</h1></div><a class="button button--primary" href="{{ route('admin.tour-dates.create') }}">Add departure</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Tour</th><th>Dates</th><th>Price</th><th>Seats</th><th>Status</th><th>Published</th><th></th></tr></thead><tbody>
@forelse($dates as $date)<tr><td><strong>{{ $date->tour?->name ?: '—' }}</strong><small>{{ $date->tour?->destination?->name ?: '—' }}</small></td><td>{{ $date->start_date?->format('d M Y') }} — {{ $date->end_date?->format('d M Y') }}</td><td>{{ $date->price !== null ? '₹'.number_format($date->price,0) : 'Tour price' }}</td><td>{{ $date->available_seats ?? '—' }} / {{ $date->total_seats ?? '—' }}</td><td><span class="status">{{ str($date->status)->replace('_',' ')->title() }}</span></td><td>{{ $date->published ? 'Yes' : 'No' }}</td><td><a href="{{ route('admin.tour-dates.edit',$date) }}">Edit</a></td></tr>
@empty<tr><td colspan="7" class="empty-cell">No departures yet. Create an actual departure for a tour.</td></tr>@endforelse
</tbody></table></div>
</section>
@endsection
