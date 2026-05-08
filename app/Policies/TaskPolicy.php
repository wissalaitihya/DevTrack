<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskPolicy
{
    // ✅ Créer — reçoit Project (pas Task)
    public function create(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    // ✅ Voir — membre du projet
    public function view(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->exists();
    }

    // ✅ Modifier — lead uniquement
    public function update(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    // ✅ Changer statut — developer assigné
    public function updateStatus(User $user, Task $task): bool
    {
        return $task->assigned_to === $user->id;
    }

    // ✅ Supprimer — lead uniquement
    public function delete(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }
}