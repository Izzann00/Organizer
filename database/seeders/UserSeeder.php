<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'orzo',
            'email' => 'orzo@organizer.local',
            'password' => Hash::make('654321ab'),
            'role' => 'admin',
        ]);
    }
}