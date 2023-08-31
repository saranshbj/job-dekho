@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <form action="{{ route('admin.store') }}" method="POST" style="max-width: 500px; margin: 0 auto;">
                    @csrf

                    <div class="mb-3">
                        <h3 class="card-header p-4 bg-secondary text-white rounded text-center">User Details</h3>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ old('location') }}">
                        @error('location')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags ( Seprated with comma )</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags"
                            name="tags" value="{{ old('tags') }}">
                        @error('tags')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Job</button>
                </form>
            </div>
        </div>
    </div>
@endsection
