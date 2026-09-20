@extends('layouts.app')
@section('content')
<section class="admin-page">
<div class="admin-header"><div><p class="eyebrow">CMS / Tours</p><h1>{{ $tour->exists ? 'Edit tour' : 'New tour' }}</h1></div><a class="button" href="{{ route('admin.tours.index') }}">Back</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ $tour->exists ? route('admin.tours.update',$tour) : route('admin.tours.store') }}" class="admin-form">
@csrf @if($tour->exists) @method('PUT') @endif

<div class="form-section"><p class="eyebrow">Identity</p><div class="form-grid form-grid--2">
<label>Destination<select name="destination_id" required><option value="">Select destination</option>@foreach($destinations as $destination)<option value="{{ $destination->id }}" @selected(old('destination_id',$tour->destination_id)==$destination->id)>{{ $destination->name }}{{ $destination->published ? '' : ' — Draft' }}</option>@endforeach</select></label>
<label>Name<input name="name" value="{{ old('name',$tour->name) }}" required></label>
<label>Slug<input name="slug" value="{{ old('slug',$tour->slug) }}" placeholder="auto-generated-from-name"></label>
<label>Hero image path / URL<input name="hero_image" value="{{ old('hero_image',$tour->hero_image) }}"></label>
</div><label>Short description<textarea name="short_description" rows="3">{{ old('short_description',$tour->short_description) }}</textarea></label>
<label>Description<textarea name="description" rows="7">{{ old('description',$tour->description) }}</textarea></label>
</div>

<div class="form-section"><p class="eyebrow">Experience</p><div class="form-grid form-grid--2">
<label>Why Visit<textarea name="why_visit" rows="5">{{ old('why_visit',$tour->why_visit) }}</textarea></label>
<label>Best Time<textarea name="best_time" rows="5">{{ old('best_time',$tour->best_time) }}</textarea></label>
<label>Base / Reference Price<input type="number" min="0" step="0.01" name="base_price" value="{{ old('base_price',$tour->base_price) }}"></label>
<label>Group Size<input type="number" min="1" name="group_size" value="{{ old('group_size',$tour->group_size) }}"></label>
<label>Safari Count<input type="number" min="0" name="safari_count" value="{{ old('safari_count',$tour->safari_count) }}"></label>
</div></div>

<div class="form-section"><p class="eyebrow">Itinerary</p><div id="itinerary-list">
@forelse(old('itinerary',$tour->itineraryDays->map(fn($day)=>['title'=>$day->title,'description'=>$day->description])->all()) as $i=>$day)
<div class="repeat-row"><strong>Day {{ $i+1 }}</strong><label>Title<input name="itinerary[{{ $i }}][title]" value="{{ $day['title'] ?? '' }}"></label><label>Description<textarea name="itinerary[{{ $i }}][description]" rows="3">{{ $day['description'] ?? '' }}</textarea></label></div>
@empty
<div class="repeat-row"><strong>Day 1</strong><label>Title<input name="itinerary[0][title]"></label><label>Description<textarea name="itinerary[0][description]" rows="3"></textarea></label></div>
@endforelse
</div><button type="button" class="button" id="add-itinerary">Add day</button></div>

<div class="form-section"><p class="eyebrow">Inclusions</p><div id="inclusions-list">
@forelse(old('inclusions',$tour->inclusions->pluck('text')->all()) as $i=>$item)<label>Item {{ $i+1 }}<input name="inclusions[]" value="{{ $item }}"></label>@empty<label>Item 1<input name="inclusions[]"></label>@endforelse
</div><button type="button" class="button" id="add-inclusion">Add inclusion</button></div>

<div class="form-section"><p class="eyebrow">Exclusions</p><div id="exclusions-list">
@forelse(old('exclusions',$tour->exclusions->pluck('text')->all()) as $i=>$item)<label>Item {{ $i+1 }}<input name="exclusions[]" value="{{ $item }}"></label>@empty<label>Item 1<input name="exclusions[]"></label>@endforelse
</div><button type="button" class="button" id="add-exclusion">Add exclusion</button></div>

<div class="form-section"><p class="eyebrow">Gallery</p><div id="gallery-list">
@forelse(old('gallery',$tour->images->map(fn($image)=>['image_path'=>$image->image_path,'caption'=>$image->caption])->all()) as $i=>$image)
<div class="repeat-row"><label>Image path / URL<input name="gallery[{{ $i }}][image_path]" value="{{ $image['image_path'] ?? '' }}"></label><label>Caption<input name="gallery[{{ $i }}][caption]" value="{{ $image['caption'] ?? '' }}"></label></div>
@empty
<div class="repeat-row"><label>Image path / URL<input name="gallery[0][image_path]"></label><label>Caption<input name="gallery[0][caption]"></label></div>
@endforelse
</div><button type="button" class="button" id="add-gallery">Add image</button></div>

<div class="form-section"><p class="eyebrow">SEO</p><div class="form-grid form-grid--2">
<label>SEO Title<input name="seo_title" value="{{ old('seo_title',$tour->seo_title) }}"></label>
<label>SEO Image path / URL<input name="seo_image" value="{{ old('seo_image',$tour->seo_image) }}"></label>
</div><label>SEO Description<textarea name="seo_description" rows="4">{{ old('seo_description',$tour->seo_description) }}</textarea></label></div>

<div class="form-section form-section--inline"><label class="check"><input type="checkbox" name="featured" value="1" @checked(old('featured',$tour->featured))> Featured tour</label><label class="check"><input type="checkbox" name="published" value="1" @checked(old('published',$tour->published))> Published</label></div>
<div class="admin-actions"><button class="button button--primary" type="submit">{{ $tour->exists ? 'Save changes' : 'Create tour' }}</button></div>
</form>
@if($tour->exists && !$tour->archived_at)<form method="POST" action="{{ route('admin.tours.archive',$tour) }}" class="danger-form">@csrf @method('PATCH')<button type="submit" class="button button--danger" onclick="return confirm('Archive this tour?')">Archive tour</button></form>@endif
</section>
<script>
document.addEventListener('DOMContentLoaded',()=>{const add=(id,html)=>document.getElementById(id).insertAdjacentHTML('beforeend',html);document.getElementById('add-itinerary')?.addEventListener('click',()=>{const n=document.querySelectorAll('#itinerary-list .repeat-row').length;add('itinerary-list',`<div class="repeat-row"><strong>Day ${n+1}</strong><label>Title<input name="itinerary[${n}][title]"></label><label>Description<textarea name="itinerary[${n}][description]" rows="3"></textarea></label></div>`)});document.getElementById('add-inclusion')?.addEventListener('click',()=>{const n=document.querySelectorAll('#inclusions-list input').length;add('inclusions-list',`<label>Item ${n+1}<input name="inclusions[]"></label>`)});document.getElementById('add-exclusion')?.addEventListener('click',()=>{const n=document.querySelectorAll('#exclusions-list input').length;add('exclusions-list',`<label>Item ${n+1}<input name="exclusions[]"></label>`)});document.getElementById('add-gallery')?.addEventListener('click',()=>{const n=document.querySelectorAll('#gallery-list .repeat-row').length;add('gallery-list',`<div class="repeat-row"><label>Image path / URL<input name="gallery[${n}][image_path]"></label><label>Caption<input name="gallery[${n}][caption]"></label></div>`)})});
</script>
@endsection
