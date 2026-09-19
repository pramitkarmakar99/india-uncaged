@extends('layouts.app')
@section('title','Plan Your Journey — India Uncaged')
@section('content')
<section class="page-intro"><p class="eyebrow">PLAN YOUR JOURNEY</p><h1>Tell us what you want to experience.</h1><p>Share a few details and our team will shape the conversation around you.</p></section>
<section class="form-page">
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice notice--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('plan.store') }}" class="public-form">@csrf
<input type="hidden" name="source" value="{{ $tour ? 'tour' : 'plan' }}">
@if($tour)<input type="hidden" name="tour_id" value="{{ $tour->id }}">@endif
<div class="form-grid form-grid--2"><label>Name *<input name="name" value="{{ old('name') }}" required></label><label>WhatsApp Number *<input name="whatsapp" value="{{ old('whatsapp') }}" required></label><label>Email<input type="email" name="email" value="{{ old('email') }}"></label>
<label>Preferred Destination<select name="destination"><option value="">Choose a destination</option>@foreach($destinations as $destination)<option value="{{ $destination->name }}" @selected(old('destination',$prefillDestination)==$destination->slug || old('destination',$prefillDestination)==$destination->name)>{{ $destination->name }}</option>@endforeach</select></label>
<label>Preferred Travel Dates<input name="preferred_dates" value="{{ old('preferred_dates') }}" placeholder="e.g. 15–20 November 2026"></label><label>Number of Travellers<input type="number" min="1" max="100" name="travellers" value="{{ old('travellers') }}"></label><label>Budget<input name="budget" value="{{ old('budget') }}" placeholder="Approx. budget per person"></label></div>
<fieldset><legend>Interests</legend><div class="interest-grid">@foreach(['Tiger','Leopard','Birds','Herping','Landscape','Photography','General Wildlife'] as $interest)<label class="check"><input type="checkbox" name="interests[]" value="{{ $interest }}" @checked(in_array($interest,old('interests',[])))>{{ $interest }}</label>@endforeach</div></fieldset>
<label>Message<textarea name="message" rows="7" placeholder="Tell us what kind of journey you have in mind.">{{ old('message') }}</textarea></label>
<button class="button button--primary" type="submit">SEND ENQUIRY</button>
</form>
</section>
@endsection