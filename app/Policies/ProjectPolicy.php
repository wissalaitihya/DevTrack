<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    // ✅ Voir un projet — lead OU developer membre
    public function view(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->exists();
    }

    // ✅ Créer un projet — tout utilisateur connecté peut créer
    public function create(User $user): bool
    {
        return true;
    }

    // ✅ Modifier un projet — uniquement le lead
    public function update(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    // ✅ Archiver un projet — uniquement le lead
    public function archive(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    // ✅ Restaurer un projet — uniquement le lead
    public function restore(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    // ✅ Supprimer définitivement — uniquement le lead
    public function forceDelete(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    // ✅ Ajouter / retirer un membre — uniquement le lead
    public function manageMember(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }
}