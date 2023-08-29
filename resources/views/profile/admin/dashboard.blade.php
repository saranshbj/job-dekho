@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')
    <div class="container">
        <div class="row justify-content-center align-items-center custom-row-height">
            <div class="col-md-4">
                <a href="{{ route('admin.show') }}" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Jobs Posted</h5>
                            <p class="card-text display-4">{{ $totalJobsPosted }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="card-link text-decoration-none">
                    <div class="card bg-primary text-white custom-card-height">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Applicants</h5>
                            <p class="card-text display-4">{{ $totalApplicants }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
