<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Lead User',
            'email'    => 'lead@devtrack.com',
            'password' => Hash::make('password'),
        ]);

        // Developers
        User::create([
            'name'     => 'Dev One',
            'email'    => 'dev1@devtrack.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Dev Two',
            'email'    => 'dev2@devtrack.com',
            'password' => Hash::make('password'),
        ]);
    }
}
