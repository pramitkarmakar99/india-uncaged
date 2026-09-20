@extends('layouts.app')

@section('content')
<section class="admin-page">
<div class="admin-header"><div><p class="eyebrow">CMS / Tours</p><h1>{{ $tour->exists ? 'Edit tour' : 'New tour' }}</h1></div><a class="button" href="{{ route('admin.tours.index') }}">Back</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<form method="POST" action="{{ $tour->exists ? route('admin.tours.update',$tour) : route('admin.tours.store') }}" class="admin-form">
@csrf @if($tour->exists) @method('PUT') @endif

<div class="form-section"><p class="eyebrow">Identity</p><div class="form-grid form-grid--2">
<label>Destination<select name="destination_id" required><option value="">Select destination</option>@foreach($destinations as $destination)<option value="{{ $destination->id }}" @selected(old('destination_id',$tour->destination_id)==$destination->id)>{{ $destination->name }}</option>@endforeach</select></label>
<label>Name<input name="name" value="{{ old('name',$tour->name) }}" required></label>
<label>Slug<input name="slug" value="{{ old('slug',$tour->slug) }}"></label>
<label>Hero image path / URL<input name="hero_image" value="{{ old('hero_image',$tour->hero_image) }}"></label>
</div></div>

<div class="form-section"><p class="eyebrow">Experience</p>
<label>Short description<input name="short_description" value="{{ old('short_description',$tour->short_description) }}"></label>
<label>Description<textarea name="description" rows="9">{{ old('description',$tour->description) }}</textarea></label>
<label>Why Visit<textarea name="why_visit" rows="6">{{ old('why_visit',$tour->why_visit) }}</textarea></label>
<label>Best Time<textarea name="best_time" rows="5">{{ old('best_time',$tour->best_time) }}</textarea></label>
<div class="form-grid form-grid--2"><label>Base / reference price<input type="number" step="0.01" min="0" name="base_price" value="{{ old('base_price',$tour->base_price) }}"></label><label>Group size<input type="number" min="1" name="group_size" value="{{ old('group_size',$tour->group_size) }}"></label><label>Safari count<input type="number" min="0" name="safari_count" value="{{ old('safari_count',$tour->safari_count) }}"></label></div>
</div>

@php
    $oldItinerary = old('itinerary');
    $oldInclusions = old('inclusions');
    $oldExclusions = old('exclusions');
    $oldGallery = old('gallery');
    $itineraryRows = is_array($oldItinerary)
        ? $oldItinerary
        : $tour->itineraryDays->map(fn($day) => ['title' => $day->title, 'description' => $day->description])->all();
    $inclusionRows = is_array($oldInclusions) ? $oldInclusions : $tour->inclusions->pluck('text')->all();
    $exclusionRows = is_array($oldExclusions) ? $oldExclusions : $tour->exclusions->pluck('text')->all();
    $galleryRows = is_array($oldGallery)
        ? $oldGallery
        : $tour->images->map(fn($image) => ['image_path' => $image->image_path, 'caption' => $image->caption])->all();
@endphp

<div class="form-section"><p class="eyebrow">Itinerary</p><p class="field-help">Add as many days as required. Empty rows are ignored.</p><div id="itinerary-list">
@if(count($itineraryRows))
@foreach($itineraryRows as $i=>$day)<div class="repeat-row"><strong>Day {{ $i+1 }}</strong><input name="itinerary[{{ $i }}][title]" value="{{ $day['title'] ?? '' }}" placeholder="Day title"><textarea name="itinerary[{{ $i }}][description]" rows="3" placeholder="Day description">{{ $day['description'] ?? '' }}</textarea></div>@endforeach
@else
<div class="repeat-row"><strong>Day 1</strong><input name="itinerary[0][title]" placeholder="Day title"><textarea name="itinerary[0][description]" rows="3" placeholder="Day description"></textarea></div>
@endif
</div><button type="button" class="button" onclick="addItinerary()">+ Add day</button></div>

<div class="form-section"><p class="eyebrow">Inclusions</p><div id="inclusions-list">@foreach($inclusionRows as $i=>$item)<input name="inclusions[{{ $i }}]" value="{{ $item }}">@endforeach</div><button type="button" class="button" onclick="addLine('inclusions-list','inclusions')">+ Add inclusion</button></div>
<div class="form-section"><p class="eyebrow">Exclusions</p><div id="exclusions-list">@foreach($exclusionRows as $i=>$item)<input name="exclusions[{{ $i }}]" value="{{ $item }}">@endforeach</div><button type="button" class="button" onclick="addLine('exclusions-list','exclusions')">+ Add exclusion</button></div>

<div class="form-section"><p class="eyebrow">Tour gallery</p><div id="gallery-list">@foreach($galleryRows as $i=>$image)<div class="repeat-row"><input name="gallery[{{ $i }}][image_path]" value="{{ $image['image_path'] ?? '' }}" placeholder="Image path / URL"><input name="gallery[{{ $i }}][caption]" value="{{ $image['caption'] ?? '' }}" placeholder="Caption"></div>@endforeach</div><button type="button" class="button" onclick="addGallery()">+ Add image</button></div>

<div class="form-section"><p class="eyebrow">SEO</p><div class="form-grid form-grid--2"><label>SEO title<input name="seo_title" value="{{ old('seo_title',$tour->seo_title) }}"></label><label>SEO image path / URL<input name="seo_image" value="{{ old('seo_image',$tour->seo_image) }}"></label></div><label>SEO description<textarea name="seo_description" rows="4">{{ old('seo_description',$tour->seo_description) }}</textarea></label></div>
<div class="form-section form-section--inline"><label class="check"><input type="checkbox" name="featured" value="1" @checked(old('featured',$tour->featured))> Featured tour</label><label class="check"><input type="checkbox" name="published" value="1" @checked(old('published',$tour->published))> Published</label></div>
<div class="admin-actions"><button class="button button--primary" type="submit">{{ $tour->exists ? 'Save changes' : 'Create tour' }}</button></div>
</form>
@if($tour->exists && !$tour->archived_at)<form method="POST" action="{{ route('admin.tours.archive',$tour) }}" class="danger-form">@csrf @method('PATCH')<button type="submit" class="button button--danger" onclick="return confirm('Archive this tour?')">Archive tour</button></form>@endif
</section>
<script>
let itineraryIndex={{ max(0,$tour->itineraryDays->count()-1) }};
function addItinerary(){const i=++itineraryIndex;document.getElementById('itinerary-list').insertAdjacentHTML('beforeend',`<div class="repeat-row"><strong>Day ${i+1}</strong><input name="itinerary[${i}][title]" placeholder="Day title"><textarea name="itinerary[${i}][description]" rows="3" placeholder="Day description"></textarea></div>`);}
function addLine(id,name){const box=document.getElementById(id),i=box.querySelectorAll('input').length;box.insertAdjacentHTML('beforeend',`<input name="${name}[${i}]" placeholder="Add item">`);}
function addGallery(){const box=document.getElementById('gallery-list'),i=box.querySelectorAll('.repeat-row').length;box.insertAdjacentHTML('beforeend',`<div class="repeat-row"><input name="gallery[${i}][image_path]" placeholder="Image path / URL"><input name="gallery[${i}][caption]" placeholder="Caption"></div>`);}
</script>
@endsection
