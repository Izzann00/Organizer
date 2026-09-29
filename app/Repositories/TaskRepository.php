<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function getAll()
    {
        return Task::with(['project', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByProject(int $projectId)
    {
        return Task::with('user')
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $id)
    {
        return Task::with(['project', 'user'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(int $id, array $data)
    {
        $task = $this->findById($id);

        $task->update($data);

        return $task;
    }

    public function delete(int $id)
    {
        $task = $this->findById($id);

        return $task->delete();
    }
}