<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::orderBy('name')->get();
    }

    public function findById(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->findById($id);

        $user->update($data);

        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->findById($id);

        return $user->delete();
    }
}