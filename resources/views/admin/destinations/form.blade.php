@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-header">
        <div><p class="eyebrow">CMS / Destinations</p><h1>{{ $destination->exists ? 'Edit destination' : 'New destination' }}</h1></div>
        <a class="button" href="{{ route('admin.destinations.index') }}">Back</a>
    </div>

    @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="notice notice--error"><strong>Please fix the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ $destination->exists ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}" class="admin-form">
        @csrf
        @if($destination->exists) @method('PUT') @endif

        <div class="form-section"><p class="eyebrow">Identity</p>
            <div class="form-grid form-grid--2">
                <label>Name<input name="name" value="{{ old('name', $destination->name) }}" required></label>
                <label>Slug<input name="slug" value="{{ old('slug', $destination->slug) }}" placeholder="auto-generated-from-name"></label>
                <label>State / Region<input name="state_region" value="{{ old('state_region', $destination->state_region) }}"></label>
                <label>Tagline<input name="tagline" value="{{ old('tagline', $destination->tagline) }}"></label>
            </div>
        </div>

        <div class="form-section"><p class="eyebrow">Story</p>
            <label>About<textarea name="about" rows="7">{{ old('about', $destination->about) }}</textarea></label>
            <label>Why Visit<textarea name="why_visit" rows="7">{{ old('why_visit', $destination->why_visit) }}</textarea></label>
        </div>

        <div class="form-section"><p class="eyebrow">Field information</p>
            <div class="form-grid form-grid--2">
                <label>Best Season<input name="best_season" value="{{ old('best_season', $destination->best_season) }}"></label>
                <label>Hero image path / URL<input name="hero_image" value="{{ old('hero_image', $destination->hero_image) }}"></label>
            </div>
            <label>Best Season Description<textarea name="best_season_description" rows="5">{{ old('best_season_description', $destination->best_season_description) }}</textarea></label>
            <label>Wildlife <span class="field-help">One item per line</span><textarea name="wildlife" rows="6">{{ old('wildlife', implode("
", $destination->wildlife ?? [])) }}</textarea></label>
            <label>Experiences <span class="field-help">One item per line</span><textarea name="experiences" rows="6">{{ old('experiences', implode("
", $destination->experiences ?? [])) }}</textarea></label>
        </div>

        <div class="form-section"><p class="eyebrow">Gallery</p>
            <p class="field-help">Select published gallery images to feature on this destination page.</p>
            <div class="form-grid form-grid--2">
                @forelse($galleryImages as $image)
                    <label class="check"><input type="checkbox" name="gallery_ids[]" value="{{ $image->id }}" @checked(in_array($image->id, old('gallery_ids', $destination->galleryImages?->pluck('id')->all() ?? [])))> {{ $image->caption ?: basename(parse_url($image->image_path, PHP_URL_PATH)) }}</label>
                @empty
                    <p class="field-help">No published gallery images available yet.</p>
                @endforelse
            </div>
        </div>

        <div class="form-section"><p class="eyebrow">SEO</p>
            <div class="form-grid form-grid--2">
                <label>SEO Title<input name="seo_title" value="{{ old('seo_title', $destination->seo_title) }}"></label>
                <label>SEO Image path / URL<input name="seo_image" value="{{ old('seo_image', $destination->seo_image) }}"></label>
            </div>
            <label>SEO Description<textarea name="seo_description" rows="4">{{ old('seo_description', $destination->seo_description) }}</textarea></label>
        </div>

        <div class="form-section form-section--inline">
            <label class="check"><input type="checkbox" name="featured" value="1" @checked(old('featured', $destination->featured))> Featured destination</label>
            <label class="check"><input type="checkbox" name="published" value="1" @checked(old('published', $destination->published))> Published</label>
        </div>

        <div class="admin-actions">
            <button class="button button--primary" type="submit">{{ $destination->exists ? 'Save changes' : 'Create destination' }}</button>
        </div>
    </form>

    @if($destination->exists && !$destination->archived_at)
        <form method="POST" action="{{ route('admin.destinations.archive', $destination) }}" class="danger-form">
            @csrf @method('PATCH')
            <button type="submit" class="button button--danger" onclick="return confirm('Archive this destination?')">Archive destination</button>
        </form>
    @endif
</section>
@endsection
