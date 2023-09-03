@extends('layouts.app')

@section('content')
    @include('navigation')

    <div class="container">
        <div id="messageContainer">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
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
                            <option value="engineering">Engineering</option>
                            <option value="marketing">Marketing</option>
                            <option value="sales">Sales</option>
                            <option value="healthcare">Healthcare</option>
                        </select>


                        <!-- Second Dropdown -->
                        <select name="date_posted" class="form-select" aria-label="Date Posted">
                            <option value="all">Date Posted</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="week">This Week</option>
                        </select>
                        <!-- Hidden input field for form identification -->
                        <input type="hidden" name="form_id" value="filter">
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
                                            <button data-jobId="{{ $job->id }}" class="viewJob btn btn-outline-primary me-2">View</button>
                                            @else
                                                {{-- checking if user already applied in the job or not --}}
                                                @php
                                                    $hasApplied = $job->jobApplications->contains('user_id', Auth::user()->id);
                                                @endphp

                                                <button data-jobId="{{ $job->id }}" class="viewJob btn btn-outline-primary me-2">View</button>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewJobButtons = document.querySelectorAll('.viewJob');

            viewJobButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jobId = this.getAttribute('data-jobId');
                    const url = `{{ route('viewJob', '') }}/${jobId}`;

                    window.location.href = url;
                });
            });
        });
    </script>
@endsection
