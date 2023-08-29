@extends('layouts.app')

@section('content')
@include('profile.admin.partials.navigation')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="{{ route('admin.store') }}" method="POST" style="max-width: 500px; margin: 0 auto;">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags ( Seprated with comma )</label>
                    <input type="text" class="form-control" id="tags" name="tags" required>
                </div>

                <button type="submit" class="btn btn-primary">Create Job</button>
            </form>
        </div>
    </div>
</div>

@endsection
