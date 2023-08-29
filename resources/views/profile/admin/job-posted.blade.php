@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if ($jobs->isEmpty())
                    <p>You haven't posted any jobs yet.</p>
                @else
                    @foreach ($jobs as $job)
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold text-primary">{{ $job->title }}</h5>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-outline-primary me-2">View</a>
                                    </div>
                                </div>
                                <p class="card-text text-muted">{{ $job->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $job->location }}</p>
                                <p class="card-text"><strong>Tags:</strong>
                                    @foreach (explode(',', $job->tags) as $tag)
                                        <a href="#" class="badge bg-primary text-decoration-none">{{ trim($tag) }}</a>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
