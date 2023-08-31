@extends('layouts.app')

@section('content')
    @include('profile.admin.partials.navigation')

    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12">
                @if ($applicants->isEmpty())
                    <p>No applicants found.</p>
                @else
                    @foreach ($applicants as $applicant)
                        <div class="card mb-4 border border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center ">
                                        <h5 class="card-title fw-bold text-primary">{{ $applicant->user->name }}</h5>
                                        <a href="" class="btn btn-sm btn-outline-primary ms-2">View Profile</a>
                                    </div>
                                    <form action="" method="POST" class="d-flex align-items-center">
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
@endsection
