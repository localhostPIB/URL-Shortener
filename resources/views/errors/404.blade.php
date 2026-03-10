@extends('layouts.app')

@section('title', 'URL Shortener')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-auto">
                <head>
                    <meta charset="UTF-8">
                    <title>404 - {{ __('messages.404-message') }}</title>
                </head>
                <body>
                <h1>404</h1>
                <p>{{ __('messages.404-message') }}</p>

                <a href="{{ url('/') }}">{{ __('messages.return-message') }}</a>
                </body>
            </div>
        </div>
    </div>
@endsection
