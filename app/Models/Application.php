<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    use HasFactory;

    protected $fillable = ['job_seeker_id', 'job_id', 'status', 'date'];

    protected $casts = [
        'status' => ApplicationStatus::class,
        'date'   => 'date',
    ];

    public function jobSeeker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
