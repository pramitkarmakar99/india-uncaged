@extends('layouts.app')
@section('title','Gallery — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">GALLERY</p><h1>Shot in the wild.</h1><p>Tour Experiences · BTS · Fauna · Herping · Birds · Landscapes</p></section>
<section class="gallery-filters">
<a class="{{ request('category') ? '' : 'is-active' }}" href="{{ route('gallery') }}">All</a>
@foreach(['tour_experiences'=>'Tour Experiences','bts'=>'BTS','fauna'=>'Fauna','herping'=>'Herping','birds'=>'Birds','landscapes'=>'Landscapes'] as $key=>$label)<a class="{{ request('category')===$key ? 'is-active' : '' }}" href="{{ route('gallery',['category'=>$key]) }}">{{ $label }}</a>@endforeach
</section>
<section class="gallery-masonry">
@forelse($images as $image)
<figure class="gallery-item"><button type="button" onclick="openLightbox(this)" data-src="{{ $image->image_path }}" data-caption="{{ $image->caption }}" aria-label="Open image"><img src="{{ $image->image_path }}" alt="{{ $image->caption ?: 'India Uncaged wildlife photograph' }}" loading="lazy"></button><figcaption><strong>{{ $image->caption }}</strong><span>{{ $image->location }}{{ $image->photographer ? ' · '.$image->photographer : '' }}</span></figcaption></figure>
@empty
<div class="empty-state"><p class="eyebrow">GALLERY</p><h2>Nothing published here yet.</h2><p>Photography will appear as the collection grows.</p></div>
@endforelse
</section>
<div id="lightbox" class="lightbox" hidden onclick="if(event.target===this)closeLightbox()"><button type="button" onclick="closeLightbox()" aria-label="Close">×</button><img id="lightbox-image" src="" alt=""><p id="lightbox-caption"></p></div>
<script>
function openLightbox(el){document.getElementById('lightbox-image').src=el.dataset.src;document.getElementById('lightbox-caption').textContent=el.dataset.caption||'';document.getElementById('lightbox').hidden=false;document.body.classList.add('no-scroll')}
function closeLightbox(){document.getElementById('lightbox').hidden=true;document.getElementById('lightbox-image').src='';document.body.classList.remove('no-scroll')}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeLightbox()});
</script>
@endsection