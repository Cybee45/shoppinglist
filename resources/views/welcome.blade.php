@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
        <div class="card-body text-center">
            <h1 class="card-title mb-3">🛒 Shopping List App</h1>
            <p class="card-text mb-4 lead">Kelola daftar belanja kamu dengan mudah, praktis, dan terorganisir!</p>
            <div class="d-grid gap-2">
                <a href="{{ route('login') }}" class="btn btn-success btn-lg">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg">Register</a>
            </div>
        </div>
    </div>
</div>
@endsection