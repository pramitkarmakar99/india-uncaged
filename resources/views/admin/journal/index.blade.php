@extends('layouts.app')
@section('content')
<section class="admin-page"><div class="admin-header"><div><p class="eyebrow">CMS / Journal</p><h1>Journal</h1></div><a class="button button--primary" href="{{ route('admin.journal.create') }}">New article</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Article</th><th>Category</th><th>Author</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($articles as $article)<tr><td><strong>{{ $article->title }}</strong><small>{{ $article->slug }}</small></td><td>{{ $article->category ?: '—' }}</td><td>{{ $article->author ?: '—' }}</td><td><span class="status">{{ $article->published ? 'Published' : 'Draft' }}</span></td><td><a href="{{ route('admin.journal.edit',$article) }}">Edit</a></td></tr>@empty<tr><td colspan="5" class="empty-cell">No journal articles yet.</td></tr>@endforelse
</tbody></table></div></section>
@endsection