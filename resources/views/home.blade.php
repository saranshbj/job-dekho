@extends('layouts.app')

@section('content')
    @include('navigation')

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="my-4 d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                <h1 class="fw-bold mb-4">Find Your Dream <mark>Job</mark></h1>
                <form action="{{ route('home') }}" method="get" class="text-center">
                    <div class="input-group input-group-lg mb-3">
                        <!-- Search Input -->
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            aria-label="Search input">
                        <!-- First Dropdown -->
                        <select name="category" class="form-select" aria-label="Category">
                            <option value="all">Categories</option>
                            <option value="category1">Category 1</option>
                            <option value="category2">Category 2</option>
                            <!-- Add more options as needed -->
                        </select>

                        <!-- Second Dropdown -->
                        <select name="location" class="form-select" aria-label="Location">
                            <option value="all">Date Posted</option>
                            <option value="location1">Location 1</option>
                            <option value="location2">Location 2</option>
                            <!-- Add more options as needed -->
                        </select>
                        <button class="btn btn-primary" type="submit">
                            Find
                        </button>
                    </div>
                </form>
            </div>

            <div class="d-flex mb-4">
                <h3 class="fw-bold text-uppercase mb-0">{{ $title }}</h3>

            </div>


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
                                        @if (auth()->check())
                                            @if (auth()->user()->role === 'admin')
                                                <a href="#" class="btn btn-outline-primary me-2">View</a>
                                            @else
                                                {{-- checking if user already applied in the job or not --}}
                                                @php
                                                    $hasApplied = $job->jobApplications->contains('user_id', Auth::user()->id);
                                                @endphp

                                                <button href="#" class="btn btn-outline-primary me-2">View</button>

                                                @if ($hasApplied)
                                                    <span class="btn btn-outline-success me-2">Applied</span>
                                                @else
                                                    <form action="{{ route('user.apply', ['userId' => $job->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button class="btn btn-outline-primary me-2">Apply</button>
                                                    </form>
                                                @endif
                                                {{-- check ends --}}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <p class="card-text text-muted">{{ $job->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $job->location }}</p>
                                <p class="card-text"><strong>Tags:</strong>
                                    @foreach (explode(',', $job->tags) as $tag)
                                        <a href="#"
                                            class="badge bg-primary text-decoration-none">{{ trim($tag) }}</a>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {{ $jobs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
