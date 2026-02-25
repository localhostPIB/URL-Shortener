@extends('layouts.app')

@section('title', 'URL Shortener')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>{{ __('pagination.app-name') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('shorten.url') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="url" class="form-label">{{__('pagination.instruction-text')}}</label>
                                <input type="url" name="url" id="url" class="form-control"
                                       placeholder="https://example.com" value="https://" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('pagination.action-button') }}</button>
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('short_url'))
                            <div class="alert alert-success mt-3 text-center">
                                <strong>{{__('messages.success-message')}}:</strong>
                                <a href="{{ session('short_url') }}" target="_blank">{{ session('short_url') }}</a>
                                @if(session('qr_code'))
                                    {!! session('qr_code') !!}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
