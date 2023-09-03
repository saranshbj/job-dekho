<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // ---- method for controlling all the get request related to search and filter ----
    public function index(Request $request)
    {
        // Creating a base query
        $query = Job::query();

        // checking if get request come from fom
        if ($request->has('form_id') && $request->input('form_id') === 'filter') {

            // checking if the search value is present
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('title', 'like', '%' . $search . '%');
            }

            // checking if the category selected
            if ($request->filled('category') && $request->input('category') !== 'all') {
                $category = $request->input('category');

                $query->where('tags', 'like', '%' . $category . '%');
            }

            // checking if the date_posted selected
            if ($request->filled('date_posted') && $request->input('date_posted') !== 'all') {
                $datePosted = $request->input('date_posted');

                if ($datePosted === 'today') {
                    $query->whereDate('created_at', now());
                } elseif ($datePosted === 'yesterday') {
                    $query->whereDate('created_at', now()->subDay());
                } elseif ($datePosted === 'week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
            }

            $jobs = $query->paginate(10);

            return view('home', [
                'jobs' => $jobs,
                'title' => 'Search and Filter Results',
            ]);
        }

        $jobs = $query->paginate(10);

        return view('home', [
            'jobs' => $jobs,
            'title' => 'All Jobs',
        ]);
    }

    // --- view single job
    public function viewJob($jobId)
    {
        $job = Job::findOrFail($jobId);

        return view('view-job', ['job' => $job]);
    }
}
