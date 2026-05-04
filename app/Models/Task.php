<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'deadline',
        'project_id',
        'assigned_to',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // ✅ Accessor — statut lisible en français (utilisé dans l'API)
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'todo'        => 'À faire',
            'in_progress' => 'En cours',
            'done'        => 'Terminé',
            default       => $this->status,
        };
    }

    // ✅ Accessor — urgence basée sur la deadline
    public function getDeadlineStatusAttribute(): string
    {
        if (!$this->deadline) return 'normal';

        return $this->deadline->diffInHours(now()) < 48 && $this->status !== 'done'
            ? 'urgent'
            : 'normal';
    }

    // ✅ BONUS — Scope : tâches urgentes (deadline < 48h et pas done)
    public function scopeUrgent($query)
    {
        return $query->where('deadline', '<=', now()->addHours(48))
                     ->where('status', '!=', 'done');
    }

    // ✅ Une tâche appartient à un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ✅ Une tâche est assignée à un user
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}