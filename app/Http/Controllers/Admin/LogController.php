<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Carbon;

class LogController extends Controller
{
    public function index()
    {
        $activity = collect()
            ->merge(User::latest()->take(10)->get()->map(function ($user) {
                return [
                    'date' => $user->created_at,
                    'message' => "New user registered: {$user->name} ({$user->role->value})",
                ];
            }))
            ->merge(Application::with(['job', 'jobSeeker'])->latest()->take(10)->get()->map(function ($application) {
                return [
                    'date' => $application->created_at,
                    'message' => "Application submitted: {$application->job->title} by {$application->jobSeeker->name}",
                ];
            }))
            ->merge(Comment::with(['job', 'user'])->latest()->take(10)->get()->map(function ($comment) {
                return [
                    'date' => $comment->created_at,
                    'message' => "Comment posted by {$comment->user->name} on {$comment->job->title}",
                ];
            }));

        $logFile = collect(glob(storage_path('logs/*.log')))->sortByDesc(function ($file) {
            return filemtime($file);
        })->first();

        if ($logFile && file_exists($logFile)) {
            $deletions = collect(array_reverse(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: []))
                ->filter(fn ($line) => str_contains($line, 'Admin deleted user account:'))
                ->take(10)
                ->map(function ($line) {
                    preg_match('/^\[(?<date>[^\]]+)\].*Admin deleted user account: (?<message>.*)$/', $line, $matches);

                    return [
                        'date' => isset($matches['date']) ? Carbon::parse($matches['date']) : now(),
                        'message' => $matches['message'] ?? $line,
                    ];
                });

            $activity = $activity->merge($deletions);
        }

        $activity = $activity->sortByDesc('date')->values();

        return view('admin.logs.index', compact('activity'));
    }
}
