@extends('layouts.app')
@section('content')
<section class="admin-page"><div class="admin-header"><div><p class="eyebrow">CMS / Enquiries</p><h1>Enquiries</h1></div></div>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Person</th><th>Request</th><th>Source</th><th>Status</th><th>Received</th><th></th></tr></thead><tbody>
@forelse($enquiries as $enquiry)<tr><td><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->whatsapp ?: $enquiry->email }}</small></td><td>{{ $enquiry->tour?->name ?: ($enquiry->destination ?: 'General enquiry') }}</td><td>{{ str($enquiry->source)->title() }}</td><td><span class="status">{{ str($enquiry->status)->title() }}</span></td><td>{{ $enquiry->created_at->format('d M Y, H:i') }}</td><td><a href="{{ route('admin.enquiries.edit',$enquiry) }}">Open</a></td></tr>@empty<tr><td colspan="6" class="empty-cell">No enquiries yet.</td></tr>@endforelse
</tbody></table></div></section>
@endsection