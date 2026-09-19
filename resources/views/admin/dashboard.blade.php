@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-header">
        <div><p class="eyebrow">India Uncaged / Admin</p><h1>Dashboard</h1></div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="button" type="submit">Sign out</button></form>
    </div>
    <div class="admin-grid">
        @foreach($counts as $label => $count)
            <article class="admin-stat"><span>{{ str($label)->replace('_',' ')->title() }}</span><strong>{{ $count }}</strong></article>
        @endforeach
    </div>
    <div class="admin-panel">
        <p class="eyebrow">Content workspace</p>
        <h2>CMS foundation is ready.</h2>
        <p class="muted">Destinations, tours, departures, gallery, journal, enquiries and site settings will be managed from this protected area.</p>
    </div>
</section>
@endsection
