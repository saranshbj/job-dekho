@extends('layouts.app')

@section('content')
    @include('profile.user.partials.navigation')

    <div class="container py-5">
        <div class="mb-3">
            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Back</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form action="{{ route('user.edit') }}" method="POST" style="max-width: 500px; margin: 0 auto;"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <h3 class="card-header p-4 bg-secondary text-white rounded text-center">User Details</h3>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number"
                            value="{{ old('phone_number', $userDetails->phone_number) }}">
                        @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $userDetails->address) }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="resume" class="form-label">Resume</label>
                        <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume"
                            name="resume">
                        @error('resume')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        @if ($userDetails->resume)
                            <div class="mt-2">
                                <strong>Current Resume:</strong>
                                <a href="{{ asset('resumes/' . $userDetails->resume) }}" target="_blank">
                                    {{ $userDetails->resume }}
                                </a>
                            </div>
                        @endif
                    </div>


                    <button type="submit" class="btn btn-primary">Save Details</button>
                </form>
            </div>
        </div>
    </div>
@endsection
