<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ✅ NOUVELLE MÉTHODE — Page profil avec stats
    public function index(Request $request): View
    {
        $user = $request->user();

        // Tâches assignées
        $myTasks = $user->tasks()
                        ->with('project')
                        ->latest()
                        ->take(5)
                        ->get();

        // Stats
        $totalProjects   = $user->projects()->count();
        $totalTasks      = $user->tasks()->count();
        $completedTasks  = $user->tasks()->where('status', 'done')->count();
        $inProgressTasks = $user->tasks()->where('status', 'in_progress')->count();

        // Rôle global
        $isLead     = $user->projects()->wherePivot('role', 'lead')->exists();
        $globalRole = $isLead ? 'Lead Developer' : 'Developer';

        return view('profile.index', compact(
            'user',
            'myTasks',
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'globalRole'
        ));
    }

    // ✅ Formulaire modifier profil (Breeze)
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // ✅ Sauvegarder modifications (Breeze)
    // ✅ Méthode update avec upload image
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();
        $user->name = $request->name;

        // ✅ Upload avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            $file     = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil mis à jour !');
    }

    // ✅ Supprimer compte (Breeze)
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}