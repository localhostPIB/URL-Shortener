@extends('layouts.app')

@section('title', 'URL Shortener')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-auto">
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
                            <button type="submit"
                                    class="btn btn-primary w-100">{{ __('pagination.action-button') }}</button>
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
                            <div class="alert alert-success mt-3 text-center break-words d-inline-block">
                                <strong>{{__('messages.success-message')}}:</strong>
                                <a href="{{ session('short_url') }}" target="_blank"
                                   class="d-block text-break">{{ session('short_url') }}</a>
                                @if(session('qr_code'))
                                    <div class="flex justify-center">
                                        <div class="w-[240px] sm:w-[260px] md:w-[320px]">
                                            <div class="flex justify-center [&>svg]:w-full [&>svg]:h-auto">
                                                {!! session('qr_code') !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
