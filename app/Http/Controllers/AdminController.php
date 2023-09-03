<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // ---- method for handling get request form admin dashboard
    public function dashboard()
    {
        $adminId = auth()->user()->id;

        // all jobs posted by admin

        $adminJobs = Job::where('admin_id', $adminId)->pluck('id');

        // count all jobs posted by admin

        $totalJobsPosted = count($adminJobs);

        // count total applicants

        $totalApplicants = JobApplication::whereIn('job_id', $adminJobs)->count();

        return view('profile.admin.dashboard', [
            'totalJobsPosted' => $totalJobsPosted,
            'totalApplicants' => $totalApplicants,
        ]);
    }

    // ---- method for redirecting admin to post-job view to post jobs
    public function post()
    {
        return view('profile.admin.post-job');
    }

    // ---- method for storing new jobs in the jobs table
    public function store(Request $request)
    {
        // validate fields

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
        ]);

        // pass errors if any

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // create job instance and add request fields

        $job = new Job();
        $job->fill($request->all());
        $job->admin_id = auth()->user()->id;

        // if jobs saved redirect back with success message

        if ($job->save()) {
            return redirect()->route('admin.show')->with('success', 'Job added successfully');
        }

        return redirect()->route('admin.show')->withInput()->with('error', 'An error occurred while adding the job.');

    }

    // ---- method for showing all the posted job by current admin
    public function show()
    {
        // // show all jobs posted by current admin

        $adminId = auth()->user()->id;
        $jobs = Job::where('admin_id', $adminId)
            ->latest()
            ->get();

        return view('profile.admin.job-posted', compact('jobs'));
    }

    // ---- method for showing all the applicants
    public function applicant()
    {
        $applicants = JobApplication::with('user', 'job')->get();
        return view('profile.admin.applicants', compact('applicants'));
    }

    // ---- method for updating application status
    public function updateStatus(Request $request, $applicationId)
    {

        $application = JobApplication::findOrFail($applicationId);

        $validatedData = $request->validate([
            'status' => ['required', 'in:applied,accepted,rejected'],
        ]);

        $application->update([
            'status' => $validatedData['status'],
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully');
    }

    // ---- view applicants profile
    public function viewProfile($applicantId)
    {

        $user = User::findOrFail($applicantId);
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        return view('profile.admin.applicant-profile', compact('user', 'userDetails'));
    }
}
