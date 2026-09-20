@extends('layouts.app')
@section('content')
<section class="admin-page"><div class="admin-header"><div><p class="eyebrow">India Uncaged / Admin</p><h1>Dashboard</h1><p class="muted">Manage the public website from one protected workspace.</p></div><form method="POST" action="{{ route('logout') }}">@csrf<button class="button" type="submit">Sign out</button></form></div>
<nav class="admin-nav" aria-label="Admin navigation">
<a href="{{ route('admin.dashboard') }}">Overview</a><a href="{{ route('admin.destinations.index') }}">Destinations</a><a href="{{ route('admin.tours.index') }}">Tours</a><a href="{{ route('admin.tour-dates.index') }}">Tour Dates</a><a href="{{ route('admin.gallery.index') }}">Gallery</a><a href="{{ route('admin.journal.index') }}">Journal</a><a href="{{ route('admin.enquiries.index') }}">Enquiries</a><a href="{{ route('admin.settings.edit') }}">Site Settings</a>
</nav>
<div class="admin-grid">@foreach($counts as $label => $count)<article class="admin-stat"><span>{{ str($label)->replace('_',' ')->title() }}</span><strong>{{ $count }}</strong></article>@endforeach</div>
<div class="admin-shortcuts"><a href="{{ route('admin.destinations.create') }}"><span>01</span><strong>New destination</strong><small>Add a wildlife destination and publish it when ready.</small></a><a href="{{ route('admin.tours.create') }}"><span>02</span><strong>New tour</strong><small>Create the wildlife experience and itinerary.</small></a><a href="{{ route('admin.tour-dates.create') }}"><span>03</span><strong>New departure</strong><small>Set the actual dates, price and seat availability.</small></a><a href="{{ route('admin.gallery.create') }}"><span>04</span><strong>Upload gallery</strong><small>Add multiple field photographs at once.</small></a></div>
</section>
@endsection