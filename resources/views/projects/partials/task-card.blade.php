<div style="
    background:white; border-radius:12px;
    padding:15px; margin-bottom:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
    border-left:4px solid {{ $task->deadline_status === 'urgent' ? '#ef4444' : '#e2e8f0' }};
">

    {{-- Priorité + Urgent --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
        <span style="
            padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;
            background:{{ $task->priority === 'high' ? '#fee2e2' : ($task->priority === 'medium' ? '#fef3c7' : '#d1fae5') }};
            color:{{ $task->priority === 'high' ? '#dc2626' : ($task->priority === 'medium' ? '#d97706' : '#059669') }};
        ">
            {{ ucfirst($task->priority) }}
        </span>

        @if($task->deadline_status === 'urgent')
            <span style="color:#ef4444; font-size:11px; font-weight:600;">🔴 Urgent</span>
        @endif
    </div>

    {{-- Titre --}}
    <h4 style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:8px;">
        {{ $task->title }}
    </h4>

    {{-- Assignee + Deadline --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <div style="display:flex; align-items:center; gap:6px;">
            <div style="
                width:24px; height:24px; border-radius:50%;
                background:#3b82f6; color:white;
                display:flex; align-items:center; justify-content:center;
                font-size:11px; font-weight:600;
            ">
                {{ strtoupper(substr($task->assignee->name ?? '?', 0, 1)) }}
            </div>
            <span style="font-size:12px; color:#64748b;">
                {{ $task->assignee->name ?? 'Non assigné' }}
            </span>
        </div>
        @if($task->deadline)
            <span style="font-size:11px; color:#94a3b8;">
                📅 {{ \Carbon\Carbon::parse($task->deadline)->format('M d') }}
            </span>
        @endif
    </div>

    {{-- Actions --}}
    <div style="display:flex; gap:6px; flex-wrap:wrap;">

        {{-- Changer statut — developer assigné --}}
        @can('updateStatus', $task)
            <form action="{{ route('tasks.updateStatus', [$project, $task]) }}" method="POST"
                  style="display:flex; gap:5px; width:100%;">
                @csrf @method('PATCH')
                <select name="status" style="
                    flex:1; padding:5px 8px;
                    border:1.5px solid #e5e7eb; border-radius:8px;
                    font-size:12px; outline:none;
                    font-family:'Outfit', sans-serif;
                ">
                    <option value="todo"        {{ $task->status === 'todo'        ? 'selected' : '' }}>À faire</option>
                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                    <option value="done"        {{ $task->status === 'done'        ? 'selected' : '' }}>Terminé</option>
                </select>
                <button style="
                    background:#3b82f6; color:white;
                    padding:5px 10px; border-radius:8px;
                    border:none; font-size:12px; cursor:pointer;
                ">OK</button>
            </form>
        @endcan

        {{-- Modifier — lead --}}
        @can('update', $task)
            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" style="
                background:#fef3c7; color:#d97706;
                padding:5px 12px; border-radius:8px;
                text-decoration:none; font-size:12px; font-weight:600;
            ">✏️ Edit</a>
        @endcan

        {{-- Supprimer — lead --}}
        @can('delete', $task)
            <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST">
                @csrf @method('DELETE')
                <button onclick="return confirm('Supprimer cette tâche ?')" style="
                    background:#fee2e2; color:#dc2626;
                    padding:5px 12px; border-radius:8px;
                    border:none; font-size:12px; font-weight:600;
                    cursor:pointer; font-family:'Outfit', sans-serif;
                ">🗑️ Delete</button>
            </form>
        @endcan

    </div>
</div>