<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // ✅ Ajouter un membre par email
    public function store(Request $request, Project $project)
    {
        $this->authorize('manageMember', $project);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérifier que le user n'est pas déjà membre
        if ($project->members()->where('user_id', $user->id)->exists()) {
            return redirect()->back()
                             ->with('error', 'Cet utilisateur est déjà membre du projet');
        }

        $project->members()->attach($user->id, ['role' => 'developer']);

        return redirect()->back()
                         ->with('success', 'Membre ajouté avec succès !');
    }

    // ✅ Retirer un membre
    public function destroy(Project $project, User $user)
    {
        $this->authorize('manageMember', $project);

        $project->members()->detach($user->id);

        return redirect()->back()
                         ->with('success', 'Membre retiré avec succès !');
    }
}