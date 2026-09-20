@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-header">
        <div><p class="eyebrow">CMS / Tours</p><h1>Tours</h1></div>
        <a class="button button--primary" href="{{ route('admin.tours.create') }}">Add tour</a>
    </div>
    @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
    <div class="admin-table-wrap"><table class="admin-table">
        <thead><tr><th>Tour</th><th>Destination</th><th>Departures</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($tours as $tour)
        <tr>
            <td><strong>{{ $tour->name }}</strong><small>{{ $tour->slug }}</small></td>
            <td>{{ $tour->destination?->name ?: '—' }}</td>
            <td>{{ $tour->dates_count }}</td>
            <td><span class="status {{ $tour->published && !$tour->archived_at ? 'status--live' : 'status--draft' }}">{{ $tour->archived_at ? 'Archived' : ($tour->published ? 'Published' : 'Draft') }}</span></td>
            <td><a href="{{ route('admin.tours.edit',$tour) }}">Edit</a></td>
        </tr>
        @empty
        <tr><td colspan="5" class="empty-cell">No tours yet. Create a tour after adding its destination.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</section>
@endsection
