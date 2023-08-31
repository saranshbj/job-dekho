@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if ($appliedJobs->isEmpty())
                    <p>You haven't applied for any jobs yet.</p>
                @else
                    @foreach ($appliedJobs as $appliedJob)
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold text-primary">{{ $appliedJob->job->title }}</h5>
                                    <p class="card-text"><strong>Current Status:</strong>
                                        <span class="badge bg-success" style="font-size: 15px">{{ ucfirst($appliedJob->status) }}</span>
                                    </p>
                                </div>
                                <p class="card-text text-muted">{{ $appliedJob->job->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $appliedJob->job->location }}</p>
                                <p class="card-text"><strong>Tags:</strong>
                                    @foreach (explode(',', $appliedJob->job->tags) as $tag)
                                        <a href="#"
                                            class="badge bg-primary text-decoration-none">{{ trim($tag) }}</a>
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
