@extends('layouts.app')
@section('content')
<section class="admin-page"><div class="admin-header"><div><p class="eyebrow">CMS / Gallery</p><h1>Gallery</h1></div><a class="button button--primary" href="{{ route('admin.gallery.create') }}">Add image</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Image</th><th>Category</th><th>Context</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($images as $image)<tr><td><strong>{{ \Illuminate\Support\Str::limit($image->caption ?: 'Untitled image',55) }}</strong><small>{{ $image->photographer ?: 'Photographer not set' }}</small></td><td>{{ str($image->category)->replace('_',' ')->title() }}</td><td>{{ $image->tour?->name ?: ($image->destination?->name ?: 'General') }}</td><td><span class="status">{{ $image->published ? 'Published' : 'Draft' }}</span></td><td><a href="{{ route('admin.gallery.edit',$image) }}">Edit</a></td></tr>@empty<tr><td colspan="5" class="empty-cell">No gallery images yet.</td></tr>@endforelse
</tbody></table></div></section>
@endsection