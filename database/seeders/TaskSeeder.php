<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $project1 = Project::where('title', 'DevTrack Platform')->first();
        $project2 = Project::where('title', 'Mobile App Redesign')->first();
        $dev1     = User::where('email', 'dev1@devtrack.com')->first();
        $dev2     = User::where('email', 'dev2@devtrack.com')->first();

        // Tasks for Project 1
        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $dev1->id,
            'title'       => 'Setup Laravel project',
            'description' => 'Initialize the Laravel project with all dependencies',
            'status'      => 'done',
            'priority'    => 'high',
            'deadline'    => '2026-05-10',
        ]);

        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $dev2->id,
            'title'       => 'Build authentication module',
            'description' => 'Implement login, register and logout',
            'status'      => 'in_progress',
            'priority'    => 'high',
            'deadline'    => '2026-05-15',
        ]);

        Task::create([
            'project_id'  => $project1->id,
            'assigned_to' => $dev1->id,
            'title'       => 'Create project CRUD',
            'description' => 'Build project create, edit, delete features',
            'status'      => 'todo',
            'priority'    => 'medium',
            'deadline'    => '2026-05-20',
        ]);

        // Tasks for Project 2
        Task::create([
            'project_id'  => $project2->id,
            'assigned_to' => $dev1->id,
            'title'       => 'Design new UI mockups',
            'description' => 'Create Figma mockups for the new design',
            'status'      => 'in_progress',
            'priority'    => 'medium',
            'deadline'    => '2026-05-25',
        ]);

        Task::create([
            'project_id'  => $project2->id,
            'assigned_to' => $dev1->id,
            'title'       => 'Implement dark mode',
            'description' => 'Add dark mode support to the app',
            'status'      => 'todo',
            'priority'    => 'low',
            'deadline'    => '2026-06-01',
        ]);
    }
}