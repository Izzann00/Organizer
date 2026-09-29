<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function getAll()
    {
        return Project::with(['category', 'owner'])
            ->orderBy('name')
            ->get();
    }

    public function getByUser(int $userId)
    {
        return Project::with(['category', 'owner'])
            ->where('owner_id', $userId)
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->orderBy('name')
            ->get();
    }

    public function findById(int $id)
    {
        return Project::with(['category', 'owner', 'users', 'tasks'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update(int $id, array $data)
    {
        $project = $this->findById($id);

        $project->update($data);

        return $project;
    }

    public function delete(int $id)
    {
        $project = $this->findById($id);

        return $project->delete();
    }

    public function addUser(int $projectId, int $userId)
    {
        $project = $this->findById($projectId);

        $project->users()->syncWithoutDetaching([$userId]);
    }

    public function removeUser(int $projectId, int $userId)
    {
        $project = $this->findById($projectId);

        $project->users()->detach($userId);
    }
}