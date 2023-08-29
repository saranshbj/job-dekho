<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('profile.admin.dashboard');
    }

    public function post()
    {
        return view('profile.admin.post-job');
    }

    public function store()
    {
        return view('profile.admin.post-job');
    }
}
