@extends('layouts.app')
@section('title','Journal — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">JOURNAL</p><h1>Field notes from the wild.</h1><p>Stories, observations and lessons from the field.</p></section>
<section class="journal-grid">@forelse($articles as $article)<a class="journal-card" href="{{ route('journal.show',$article) }}"><div class="journal-card__image" style="{{ $article->cover_image ? "background-image:url('".e($article->cover_image)."')" : '' }}"></div><div><p class="eyebrow">{{ $article->category }}</p><h2>{{ $article->title }}</h2><p>{{ $article->excerpt }}</p><small>{{ $article->published_at?->format('d M Y') }}{{ $article->author ? ' · '.$article->author : '' }}</small></div></a>@empty<div class="empty-state"><p class="eyebrow">JOURNAL</p><h2>The field notes are coming.</h2><p>Published stories will appear here.</p></div>@endforelse</section>
@endsection