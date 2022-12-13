@extends('layouts.app')

@section('content')
<div class="container">

    <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>403</h1>
        <h2>{{ __($exception->getMessage() ?: 'Forbidden') }}</h2>
        <a class="btn" href="{{ route('index') }}">Back to home</a>
        <img src="{{ asset('niceadmin/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
    </section>

</div>
@endsection