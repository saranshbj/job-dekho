@extends('layouts.app')

@section('content')
    @include('navigation')
    <div class="container my-5">
        <div class="row">
            <div class="mb-3" style="padding:0;">
                <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ $job->title }}</h3>
                    <p class="card-text">{{ $job->description }}</p>
                    <hr>
                    <p><strong>Location:</strong> {{ $job->location }}</p>
                    <hr>
                    <p><strong>Tags:</strong>
                        @foreach (explode(',', $job->tags) as $tag)
                            <span class="badge bg-primary">{{ trim($tag) }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </div>
    <style>
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }
    </style>
@endsection
