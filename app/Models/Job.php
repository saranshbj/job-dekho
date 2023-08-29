<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'tags', 'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
