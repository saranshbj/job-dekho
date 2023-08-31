@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container-fluid py-5 bg-light">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="card ">
                    <h3 class="card-header p-4 bg-secondary text-white">User Profile</h3>
                    <div class="card-body p-4 ">
                        <h4 class="card-title">{{ $user->name }}</h4>
                        <p class="card-text email h5"><span class="badge text-bg-warning">{{ $user->email }}</span></p>

                        <hr>

                        <div class="field-group">
                            <h5 class="field-label">Phone Number</h5>
                            <p class="field-value">{{ $userDetails->phone_number ?? 'Not available' }}</p>
                        </div>

                        <hr>

                        <div class="field-group">
                            <h5 class="field-label">Address</h5>
                            <p class="field-value">{{ $userDetails->address ?? 'Not available' }}</p>
                        </div>

                        <hr>

                        <div class="field-group">
                            <h5 class="field-label">Resume</h5>
                            @if ($userDetails && $userDetails->resume)
                                <a href="{{ asset('storage/' . $userDetails->resume) }}" target="_blank" class="form-text">View Resume</a>
                            @else
                                <p class="field-value">Not available</p>
                            @endif
                        </div>

                        <hr>

                        <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .field-group {
        margin-bottom: 1.5rem;
    }

    .field-label {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.2rem;
    }

    .field-value {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
</style>



