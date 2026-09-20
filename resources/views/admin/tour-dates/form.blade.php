@extends('layouts.app')
@section('content')
<section class="admin-page">
<div class="admin-header"><div><p class="eyebrow">CMS / Departures</p><h1>{{ $tourDate->exists ? 'Edit departure' : 'New departure' }}</h1></div><a class="button" href="{{ route('admin.tour-dates.index') }}">Back</a></div>
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ $tourDate->exists ? route('admin.tour-dates.update',$tourDate) : route('admin.tour-dates.store') }}" class="admin-form">
@csrf @if($tourDate->exists) @method('PUT') @endif
<div class="form-section"><p class="eyebrow">Departure</p><div class="form-grid form-grid--2">
<label>Tour<select name="tour_id" required><option value="">Select tour</option>@foreach($tours as $tour)<option value="{{ $tour->id }}" @selected(old('tour_id',$tourDate->tour_id)==$tour->id)>{{ $tour->name }}</option>@endforeach</select></label>
<label>Status<select name="status" required>@foreach(['upcoming','almost_full','full','cancelled','completed'] as $status)<option value="{{ $status }}" @selected(old('status',$tourDate->status)==$status)>{{ str($status)->replace('_',' ')->title() }}</option>@endforeach</select></label>
<label>Start date<input type="date" name="start_date" value="{{ old('start_date',$tourDate->start_date?->format('Y-m-d')) }}" required></label>
<label>End date<input type="date" name="end_date" value="{{ old('end_date',$tourDate->end_date?->format('Y-m-d')) }}" required></label>
<label>Departure price<input type="number" min="0" step="0.01" name="price" value="{{ old('price',$tourDate->price) }}"></label>
<label>Total seats<input type="number" min="1" name="total_seats" value="{{ old('total_seats',$tourDate->total_seats) }}"></label>
<label>Available seats<input type="number" min="0" name="available_seats" value="{{ old('available_seats',$tourDate->available_seats) }}"></label>
</div></div>
<div class="form-section form-section--inline"><label class="check"><input type="checkbox" name="published" value="1" @checked(old('published',$tourDate->published))> Published departure</label></div>
<div class="admin-actions"><button class="button button--primary" type="submit">{{ $tourDate->exists ? 'Save changes' : 'Create departure' }}</button></div>
</form>
@if($tourDate->exists)<form method="POST" action="{{ route('admin.tour-dates.destroy',$tourDate) }}" class="danger-form">@csrf @method('DELETE')<button type="submit" class="button button--danger" onclick="return confirm('Delete this departure?')">Delete departure</button></form>@endif
</section>
@endsection
