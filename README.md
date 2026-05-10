# DevTrack

**A lightweight project & task management tool built for dev teams.**  
Team Leads create projects, manage members, and assign tasks.  
Developers track and update their own tasks in real time.

</div>

---

## 📌 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Database Schema](#-database-schema)
- [Installation](#-installation)
- [Test Credentials](#-test-credentials)
- [API](#-api-endpoint)
- [Git Workflow](#-git-workflow)
- [Team](#-team)

---

## 🧭 Overview

DevTrack is an internal tool developed for a startup based in Technopark Agadir.  
Before DevTrack, the Team Lead was managing tasks via WhatsApp, Excel, and scattered notes.  
Developers had no clear view of their assignments or project progress.

DevTrack solves this by providing:
- A clean dashboard per user showing only relevant projects
- Role-based access control (Lead vs Developer)
- Full task lifecycle management
- A REST API for external integrations

---

## ✅ Features

### Authentication
- [x] Register, Login, Logout via Laravel Breeze

### Projects
- [x] Create / Edit projects (Lead only)
- [x] Archive projects with SoftDeletes
- [x] Restore archived projects
- [x] Force delete from archives (bonus)
- [x] Add / Remove members by email
- [x] Dashboard shows task progress per project

### Tasks
- [x] Create / Edit / Delete tasks (Lead only)
- [x] Assign tasks to project members
- [x] Set priority (low / medium / high)
- [x] Set deadline with overdue indicator
- [x] Developer can update status of their own task only
- [x] Urgent scope — tasks due in less than 48h

### API
- [x] `GET /api/projects/{project}/tasks` — returns tasks as JSON via TaskResource

### Bonus
- [x] `ucfirst` mutator on Project title
- [x] `urgent()` local scope on Task model
- [x] `status_label` accessor on Task model

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 13 |
| Language | PHP 8.3 |
| Database | MySQL 8 |
| Authentication | Laravel Breeze |
| Authorization | Laravel Policies |
| Validation | Form Request Classes |
| Debugging | Laravel Telescope + Debugbar |
| Frontend | Bootstrap 5 + Bootstrap Icons |
| Version Control | Git + GitHub |

---

## 🗄️ Database Schema

```
┌─────────────┐       ┌──────────────────┐       ┌─────────────┐
│    users    │       │  project_user    │       │  projects   │
│─────────────│       │──────────────────│       │─────────────│
│ id          │◄──────│ user_id (FK)     │──────►│ id          │
│ name        │       │ project_id (FK)  │       │ title       │
│ email       │       │ role             │       │ description │
│ password    │       │ (lead/developer) │       │ deadline    │
└─────────────┘       └──────────────────┘       │ deleted_at  │
                                                  └──────┬──────┘
                                                         │
                                                         ▼
                                                  ┌─────────────┐
                                                  │    tasks    │
                                                  │─────────────│
                                                  │ id          │
                                                  │ title       │
                                                  │ description │
                                                  │ status      │
                                                  │ priority    │
                                                  │ deadline    │
                                                  │ project_id  │
                                                  │ assigned_to │
                                                  └─────────────┘
```

---

## ⚙️ Installation

### Prerequisites

- PHP >= 8.3
- Composer
- MySQL
- Laragon (recommended) or any local server

### Setup

```bash
# 1. Clone the repository
git clone https://github.com/wissalaitihya/DevTrack.git
cd DevTrack

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=devtrack
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seed test data
php artisan migrate:fresh --seed

# 6. Start development server
php artisan serve
```

Visit **http://localhost:8000**

---

## 🔑 Test Credentials

| Role | Email | Password |
|------|-------|----------|
| Team Lead | lead@devtrack.com | password |
| Developer | dev1@devtrack.com | password |
| Developer | dev2@devtrack.com | password |

---

## 📡 API Endpoint

### Get tasks for a project

```http
GET /api/projects/{project}/tasks
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "Setup Laravel project",
      "description": "Initialize the project with all dependencies",
      "status": "done",
      "status_label": "Done",
      "priority": "high",
      "deadline": "2026-05-10",
      "assigned_to": "Dev One"
    },
    {
      "id": 2,
      "title": "Build authentication module",
      "description": "Implement login, register and logout",
      "status": "in_progress",
      "status_label": "In Progress",
      "priority": "high",
      "deadline": "2026-05-15",
      "assigned_to": "Dev Two"
    }
  ]
}
```

---

## 🔐 Security

| Concern | Solution |
|---------|----------|
| Route protection | `auth` middleware on all routes |
| Project authorization | `ProjectPolicy` with `@can` in views |
| Task authorization | `TaskPolicy` with `@can` in views |
| Input validation | Form Request classes on all forms |
| CSRF protection | `@csrf` on all forms |
| Ownership | Only Lead can edit/delete, only assigned dev can update status |

---

## 🧰 Debugging

### Laravel Telescope
```
http://localhost:8000/telescope
```
- Inspect every HTTP request with full payload
- View all SQL queries executed per request
- Track exceptions and errors

### Laravel Debugbar
- Visible at the bottom of every page in development
- Shows query count per page
- Used to detect and fix N+1 query problems

---

## 🌿 Git Workflow

```
main
├── feat/database-setup   → Migrations, Models, Seeders
├── feat/auth             → Laravel Breeze authentication
├── feat/projects         → Project CRUD, Members, Policies
├── feat/tasks            → Task CRUD, TaskPolicy
├── feat/api              → API endpoint + TaskResource
└── feat/bonus            → Mutator, Scope, Force delete
```

> All features developed on separate branches with Pull Requests before merging to `main`.

---

## 👥 Team

| Member | Responsibilities |
|--------|-----------------|
| **Wissal** | Repository creation, API development, Database setup & seeders, Debugbar & Telescope installation, Routes, Jira management, Tasks, and Policies|
| **Hassan** | MCD & MLD design, Models, Authentication, Controllers, and Form Requests, Views |

---

## 📄 License

This project was developed as part of a training program at **Technopark Agadir**.  
For educational purposes only.