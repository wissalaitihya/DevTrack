@extends('layouts.app')

@section('content')

    <style>
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-left: 4px solid #3b82f6;
        }

        .stat-card.green {
            border-left-color: #10b981;
        }

        .stat-card.blue {
            border-left-color: #3b82f6;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-card-title {
            font-size: 14px;
            color: #6b7280;
            font-weight: 600;
        }

        .stat-card-icon {
            width: 24px;
            height: 24px;
            opacity: 0.7;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .stat-card-meta {
            font-size: 13px;
            color: #9ca3af;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-container {
            height: 300px;
            display: flex;
            align-items: flex-end;
            gap: 12px;
            padding: 20px 0;
        }

        .chart-bar {
            flex: 1;
            background: linear-gradient(to top, #3b82f6, #60a5fa);
            border-radius: 4px 4px 0 0;
            min-height: 40px;
            transition: all 0.3s ease;
        }

        .chart-bar:hover {
            opacity: 0.8;
        }

        .projects-table {
            width: 100%;
            border-collapse: collapse;
        }

        .projects-table thead {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .projects-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .projects-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
            color: #1f2937;
        }

        .projects-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-in-progress {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-done {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-todo {
            background-color: #e5e7eb;
            color: #374151;
        }

        .projects-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .project-card-new {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .project-card-new:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .project-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .project-card-desc {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .project-card-progress {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .project-card-progress-bar {
            height: 100%;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            border-radius: 3px;
        }

        .project-card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .project-card-actions {
            display: flex;
            gap: 8px;
        }

        .btn-small {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6b7280;
            text-decoration: none;
            text-align: center;
        }

        .btn-small:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .btn-small-primary {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .btn-small-primary:hover {
            background: #2563eb;
            border-color: #2563eb;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 8px;
        }

        .empty-state p {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2563eb;
        }
    </style>

    <!-- Stats Cards -->
    <div class="dashboard-stats">
        <div class="stat-card blue">
            <div class="stat-card-header">
                <span class="stat-card-title">Active Projects:</span>
                <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.5V13h1v-.5a.5.5 0 0 1 1 0V13h1a.5.5 0 0 1 0 1h-1v.5a.5.5 0 0 1-1 0V14h-1a.5.5 0 0 1 0-1zm-10 0a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                </svg>
            </div>
            <div class="stat-card-value">{{ $projects->count() }}</div>
            <div class="stat-card-meta">All active projects</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-header">
                <span class="stat-card-title">Completed Tasks:</span>
                <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                </svg>
            </div>
            <div class="stat-card-value">
                {{ $projects->flatMap(function ($p) {
        return $p->tasks->where('status', 'done'); })->count() }}</div>
            <div class="stat-card-meta">This Month: +{{ rand(5, 15) }}</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-card-header">
                <span class="stat-card-title">Team Velocity:</span>
                <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h5v-2z" />
                </svg>
            </div>
            <div class="stat-card-value">{{ rand(40, 70) }} pts</div>
            <div class="stat-card-meta">Sprint 4</div>
        </div>
    </div>

    <!-- Charts and Recent Tasks -->
    <div class="dashboard-grid">
        <!-- Project Progression Chart -->
        <div class="card">
            <div class="card-title">
                Project Progression (Last 6 Weeks)
                <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 12h-2v-2h-2v2h-2v2h2v2h2v-2h2v-2zm-8-6H9v6H7V6H5v12h14V6h-8z" />
                </svg>
            </div>
            <div class="chart-container">
                <div class="chart-bar" style="height: 45%;"></div>
                <div class="chart-bar" style="height: 60%;"></div>
                <div class="chart-bar" style="height: 75%;"></div>
                <div class="chart-bar" style="height: 40%;"></div>
                <div class="chart-bar" style="height: 65%;"></div>
                <div class="chart-bar" style="height: 85%;"></div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="card">
            <div class="card-title">Recent Tasks</div>
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Project</th>
                        <th>Assignee</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects->flatMap(function ($p) {
                            return $p->tasks()->orderBy('created_at', 'desc')->limit(3)->get()->map(function ($t) use ($p) {
                                $t->project = $p;
                        return $t; }); }) as $task)
                        <tr>
                            <td>{{ Str::limit($task->title, 15) }}</td>
                            <td>{{ Str::limit($task->project->title, 15) }}</td>
                            <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                            <td>
                                <span
                                    class="status-badge {{ $task->status == 'done' ? 'status-done' : ($task->status == 'in_progress' ? 'status-in-progress' : 'status-todo') }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #9ca3af;">No tasks yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Projects Section -->
    <div class="card">
        <div class="card-title">
            My Projects
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">
                    + New Project
                </a>
            @endcan
        </div>

        @if($projects->isEmpty())
            <div class="empty-state">
                <p>No projects yet. Create your first project to get started!</p>
                @can('create', App\Models\Project::class)
                    <a href="{{ route('projects.create') }}" class="btn-primary">
                        Create First Project
                    </a>
                @endcan
            </div>
        @else
            <div class="projects-list">
                @foreach($projects as $project)
                    <div class="project-card-new">
                        <div class="project-card-title">{{ $project->title }}</div>
                        <div class="project-card-desc">{{ $project->description ?? 'No description' }}</div>

                        <div class="project-card-progress">
                            <div class="project-card-progress-bar"
                                style="width: {{ $project->tasks_count > 0 ? ($project->tasks->where('status', 'done')->count() / $project->tasks_count * 100) : 0 }}%;">
                            </div>
                        </div>

                        <div class="project-card-meta">
                            <span>📅 {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</span>
                            <span>✅ {{ $project->tasks->where('status', 'done')->count() }}/{{ $project->tasks_count }}</span>
                        </div>

                        <div class="project-card-actions">
                            <a href="{{ route('projects.show', $project) }}" class="btn-small btn-small-primary">View</a>
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}" class="btn-small">Edit</a>
                            @endcan
                            @can('archive', $project)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" style="flex: 1;"
                                    onsubmit="return confirm('Archive this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small" style="width: 100%;">Archive</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection