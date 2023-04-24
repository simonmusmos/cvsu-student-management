@extends('layouts.auth-master')

@section('content')
        <img class="mb-4" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57">
        
        <h1 class="h3 mb-3 fw-normal">Login</h1>

        <a class="w-100 btn btn-lg btn-primary" href="{{ route('oauth.redirect', ['google']) }}" target="_blank">Login using Google</a>
@endsection