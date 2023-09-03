<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ---- method for providing job applied, job accepted and job rejected count to user dashboard
    public function dashboard()
    {
        $user = auth()->user();

        // jobs applied count
        $jobApplicationsCount = JobApplication::where('user_id', $user->id)->count();

        // jobs accepted count
        $jobAcceptedCount = JobApplication::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->count();

        // jobs rejected count
        $jobRejectedCount = JobApplication::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->count();

        return view('profile.user.dashboard', compact('jobApplicationsCount', 'jobAcceptedCount', 'jobRejectedCount'));
    }

    // ---- method for showing user details in profile view
    public function profile()
    {
        $user = Auth::user();
        $userDetails = $user->userDetails;
        return view('profile.user.profile', compact('user', 'userDetails'));
    }

    // ---- method for controlling both get and post request and its used to update user profile details
    public function edit(Request $request)
    {
        // if received get request
        if ($request->isMethod('get')) {

            $user = auth()->user();
            $userDetails = $user->userDetails ?? new UserDetails();
            return view('profile.user.profile-edit', compact('user', 'userDetails'));
        }

        // if received post request
        if ($request->isMethod('post')) {

            // getting current user id
            $userId = auth()->user()->id;
            $user = User::find($userId);

            $validatedData = $request->validate([
                'name' => 'required|string',
                'phone_number' => 'required|string',
                'address' => 'required|string',
                'resume' => 'file|mimes:pdf,doc,docx|max:2048',
            ]);

            // update the user name in users table
            $user->name = $validatedData['name'];
            $user->save();

            // update user details in user_details table
            $userDetails = $user->userDetails ?? new UserDetails();
            $userDetails->phone_number = $validatedData['phone_number'];
            $userDetails->address = $validatedData['address'];
            $userDetails->user_id = $userId;


            if ($request->hasFile('resume')) {
                // Delete previous resume if available
                if ($userDetails->resume) {
                    // Delete the previous resume from the public folder
                    $previousResumePath = public_path('resumes/' . $userDetails->resume);
                    if (file_exists($previousResumePath)) {
                        unlink($previousResumePath);
                    }
                }

                $resumeFile = $request->file('resume');
                $resumeExtension = $resumeFile->getClientOriginalExtension();
                $uniqueFilename = 'resume_' . time() . '.' . $resumeExtension;

                // Save the resume file to the public folder
                $resumeFile->move(public_path('resumes'), $uniqueFilename);

                $userDetails->resume = $uniqueFilename;
            }


            $userDetails->save();
            return redirect()->route('user.profile')->with('success', 'User details updated successfully.');
        }
    }

    // ---- method to add record in job_application table when an user applies a job
    public function apply(Request $request, $jobId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $job = Job::findOrFail($jobId);

        $existingApplication = JobApplication::where('user_id', $user->id)
            ->where('job_id', $job->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('warning', 'You have already applied for this job.');
        }

        $application = new JobApplication();
        $application->user_id = $user->id;
        $application->job_id = $job->id;
        $application->save();

        return redirect()->back()->with('success', 'You have applied for this job.');
    }

    // ---- method for showing all the applied jobs to the user in job-applied view
    public function applied()
    {
        $user = User::findOrFail(auth()->id());
        $appliedJobs = $user->jobApplications()->with('job')->get();
        return view('profile.user.job-applied', compact('appliedJobs'));
    }
}
