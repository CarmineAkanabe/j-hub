<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{

    use HasFactory;

    protected $table = 'jobs_post';

    protected $fillable = [
        'employer_id', 'title', 'description', 'location', 'expected_salary', 'status'
    ];

    protected $casts = [
        'status' => JobStatus::class,
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
