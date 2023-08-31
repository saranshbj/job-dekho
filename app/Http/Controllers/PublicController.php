<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        // creating query instance
        $query = Job::query();

        // this condition will run if the get request received with a search query
        if ($request->has('search')) {
            $search = $request->input('search');
            $jobs = $query->where('title', 'like', '%' . $search . '%')->paginate(10);

            return view('home', [
                'jobs' => $jobs,
                'title' => 'Search Results',
            ]);
        }

        // this condition will run if the get request received with filters
        if ($request->has('category') && $request->has('date_posted')) {
            $category = $request->input('category');
            $datePosted = $request->input('date_posted');

            if ($datePosted === 'today') {
                $query->whereDate('created_at', now());
            } elseif ($datePosted === 'yesterday') {
                $query->whereDate('created_at', now()->subDay());
            } elseif ($datePosted === 'week') {
                $query->whereBetween('created_at', [now()->subWeek(), now()]);
            }

            $jobs = $query->where('category', $category)->paginate(10);

            return view('home', [
                'jobs' => $jobs,
                'title' => 'Filtered Results',
            ]);
        }

        // Default
        $jobs = Job::paginate(10);

        return view('home', [
            'jobs' => $jobs,
            'title' => 'All Jobs',
        ]);
    }
}
