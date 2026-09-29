<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function isClosed(Project $project): bool
    {
        $tasks = $project->tasks;

        if ($tasks->isEmpty()) {
            return false;
        }

        return $tasks->every(function ($task) {
            return $task->status === 'closed';
        });
    }

    public function canAccess(Project $project, int $userId): bool
    {
        if ($project->owner_id === $userId) {
            return true;
        }

        return $project->users->contains('id', $userId);
    }

    public function isOwner(Project $project, int $userId): bool
    {
        return $project->owner_id === $userId;
    }

}