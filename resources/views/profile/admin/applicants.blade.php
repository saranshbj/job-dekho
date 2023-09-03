@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div id="applicants-section" class="col-md-12">
                {{-- alerts will be shown here  --}}
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
                @if ($applicants->isEmpty())
                    <p>No applicants found.</p>
                @else
                    @foreach ($applicants as $applicant)
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center ">
                                        <h5 class="card-title fw-bold text-primary">{{ $applicant->user->name }}</h5>
                                        <button data-applicant-id="{{ $applicant->user->id }}"
                                            class="viewProfile btn btn-sm btn-outline-primary ms-2">View Profile</button>
                                    </div>
                                    <form action="{{ route('admin.update', ['applicationId' => $applicant->id]) }}"
                                        method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" id="status" class="form-select me-2">
                                            <option value="applied"
                                                {{ $applicant->status === 'applied' ? 'selected' : '' }}>
                                                Applied</option>
                                            <option value="accepted"
                                                {{ $applicant->status === 'accepted' ? 'selected' : '' }}>
                                                Accepted</option>
                                            <option value="rejected"
                                                {{ $applicant->status === 'rejected' ? 'selected' : '' }}>
                                                Rejected</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                    </form>
                                </div>
                                <p class="card-text"><strong>Applied for:</strong> {{ $applicant->job->title }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $applicant->job->location }}</p>
                                <p class="card-text"><strong>Description:</strong> {{ $applicant->job->description }}</p>
                                <p class="card-text"><strong>Tags:</strong>
                                    @foreach (explode(',', $applicant->job->tags) as $tag)
                                        <span class="badge bg-primary text-decoration-none">{{ trim($tag) }}</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewProfileButtons = document.querySelectorAll('.viewProfile');

            viewProfileButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const applicantId = this.getAttribute('data-applicant-id');
                    const url = `{{ route('admin.viewProfile', '') }}/${applicantId}`;

                    window.location.href = url;
                });
            });
        });
    </script>
@endsection
