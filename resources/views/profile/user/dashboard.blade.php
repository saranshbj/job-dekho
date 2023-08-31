@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')
    <div class="container">
        <div class="row justify-content-center align-items-center custom-row-height">
            <div class="col-md-4">
                <a href="{{ route('user.applied') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h5 class="card-title">Job Applied</h5>
                            <p class="card-text display-4">{{ $jobApplicationsCount }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white custom-card-height">
                    <div class="card-body text-center">
                        <h5 class="card-title">Job Accepted</h5>
                        <p class="card-text display-4">{{ $jobAcceptedCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white custom-card-height">
                    <div class="card-body text-center">
                        <h5 class="card-title">Job Rejected</h5>
                        <p class="card-text display-4">{{ $jobRejectedCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
