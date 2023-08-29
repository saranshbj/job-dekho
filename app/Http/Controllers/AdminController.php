<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $adminId = auth()->user()->id;

         // Get all jobs posted by the admin
         $adminJobs = Job::where('admin_id', $adminId)->pluck('id');

         // Count total jobs posted
         $totalJobsPosted = count($adminJobs);

         // Count total applicants for the admin's jobs
         $totalApplicants = JobApplication::whereIn('job_id', $adminJobs)->count();

         return view('profile.admin.dashboard', [
            'totalJobsPosted' => $totalJobsPosted,
            'totalApplicants' => $totalApplicants,
        ]);
    }

    public function post()
    {
        return view('profile.admin.post-job');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $job = new Job();
        $job->fill($request->all());
        $job->admin_id = auth()->user()->id;

        if ($job->save()) {
            return redirect()->back()->with('success', 'Job added successfully');
        }
        return redirect()->back()->withInput()->with('error', 'An error occurred while adding the job.');
    }

    public function show()
    {
        $adminId = auth()->user()->id;
        $jobs = Job::where('admin_id', $adminId)->get();
        return view('profile.admin.job-posted', compact('jobs'));
    }
}
