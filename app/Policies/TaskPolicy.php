<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // ✅ Voir une tâche — tout membre du projet
    public function view(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->exists();
    }

    // ✅ Créer une tâche — uniquement le lead
    public function create(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    // ✅ Modifier une tâche — uniquement le lead
    public function update(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    // ✅ Changer uniquement le statut — developer assigné à la tâche
    public function updateStatus(User $user, Task $task): bool
    {
        return $task->assigned_to === $user->id;
    }

    // ✅ Supprimer une tâche — uniquement le lead
    public function delete(User $user, Task $task): bool
    {
        return $task->project->members()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }
}