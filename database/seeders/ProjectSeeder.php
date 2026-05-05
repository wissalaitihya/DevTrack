<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $lead = User::where('email', 'lead@devtrack.com')->first();
        $dev1 = User::where('email', 'dev1@devtrack.com')->first();
        $dev2 = User::where('email', 'dev2@devtrack.com')->first();

        // Project 1
        $project1 = Project::create([
            'title'       => 'DevTrack Platform',
            'description' => 'Internal project management tool',
            'deadline'    => '2026-06-01',
        ]);

        // Attach members with roles
        $project1->users()->attach($lead->id, ['role' => 'lead']);
        $project1->users()->attach($dev1->id, ['role' => 'developer']);
        $project1->users()->attach($dev2->id, ['role' => 'developer']);

        // Project 2
        $project2 = Project::create([
            'title'       => 'Mobile App Redesign',
            'description' => 'Redesign the mobile application UI',
            'deadline'    => '2026-07-15',
        ]);

        // Attach members with roles
        $project2->users()->attach($lead->id, ['role' => 'lead']);
        $project2->users()->attach($dev1->id, ['role' => 'developer']);
    }
}
