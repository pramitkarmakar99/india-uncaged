@extends('layouts.app')
@section('title',$article->title.' — India Uncaged')
@section('content')
<section class="article-hero" style="{{ $article->cover_image ? "background-image:url('".e($article->cover_image)."')" : '' }}"><div><p class="eyebrow">{{ $article->category }}</p><h1>{{ $article->title }}</h1><p>{{ $article->published_at?->format('d M Y') }}{{ $article->author ? ' · '.$article->author : '' }}</p></div></section>
<article class="article-body"><p class="article-excerpt">{{ $article->excerpt }}</p><div class="article-content">{!! $article->content[0]['value'] ?? '' !!}</div></article>
@if($related->count())<section class="related-section"><div class="section-heading"><p class="eyebrow">KEEP READING</p><h2>More from the journal</h2></div><div class="journal-grid">@foreach($related as $item)<a class="journal-card" href="{{ route('journal.show',$item) }}"><div class="journal-card__image" style="{{ $item->cover_image ? "background-image:url('".e($item->cover_image)."')" : '' }}"></div><div><p class="eyebrow">{{ $item->category }}</p><h2>{{ $item->title }}</h2></div></a>@endforeach</div></section>@endif
@endsection