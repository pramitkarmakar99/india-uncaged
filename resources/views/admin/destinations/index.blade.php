@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-header">
        <div><p class="eyebrow">CMS / Destinations</p><h1>Destinations</h1></div>
        <a class="button button--primary" href="{{ route('admin.destinations.create') }}">Add destination</a>
    </div>

    @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Destination</th><th>Region</th><th>Tours</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($destinations as $destination)
                <tr>
                    <td><strong>{{ $destination->name }}</strong><small>{{ $destination->slug }}</small></td>
                    <td>{{ $destination->state_region ?: '—' }}</td>
                    <td>{{ $destination->tours_count }}</td>
                    <td><span class="status {{ $destination->published && !$destination->archived_at ? 'status--live' : 'status--draft' }}">{{ $destination->archived_at ? 'Archived' : ($destination->published ? 'Published' : 'Draft') }}</span></td>
                    <td><a href="{{ route('admin.destinations.edit', $destination) }}">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-cell">No destinations yet. Add your first destination when your content is ready.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
