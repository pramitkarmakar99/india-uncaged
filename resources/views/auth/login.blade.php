@extends('layouts.app')

@section('content')
<section class="auth-page">
    <div class="auth-card">
        <p class="eyebrow">India Uncaged / Admin</p>
        <h1>Sign in</h1>
        <p class="muted">Private access for India Uncaged administrators.</p>

        <form method="POST" action="{{ route('login') }}" class="form-grid">
            @csrf
            <label>Email<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
            <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
            <button class="button button--primary" type="submit">Sign in</button>
        </form>
    </div>
</section>
@endsection
