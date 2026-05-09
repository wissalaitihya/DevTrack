@extends('layouts.app')

@section('content')

<div style="max-width:600px; margin:0 auto;">

    <h1 style="font-size:22px; font-weight:700; color:#1a1a2e; margin-bottom:25px;">
        Create New Project
    </h1>

    <div style="background:white; border-radius:16px; padding:35px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            {{-- Project Name --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Project Name
                </label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="e.g., Website Redesign"
                       style="
                           width:100%; padding:11px 15px;
                           border:1.5px solid #e5e7eb; border-radius:10px;
                           font-size:14px; outline:none;
                           font-family:'Outfit',sans-serif;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('title')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Description
                </label>
                <textarea name="description" rows="3"
                          placeholder="Enter project description..."
                          style="
                              width:100%; padding:11px 15px;
                              border:1.5px solid #e5e7eb; border-radius:10px;
                              font-size:14px; outline:none; resize:vertical;
                              font-family:'Outfit',sans-serif;
                              box-sizing:border-box;
                          "
                          onfocus="this.style.borderColor='#3b82f6'"
                          onblur="this.style.borderColor='#e5e7eb'">{{ old('description') }}</textarea>
            </div>

            {{-- Deadline --}}
            <div style="margin-bottom:25px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Deadline
                </label>
                <input type="date" name="deadline"
                       value="{{ old('deadline') }}"
                       style="
                           width:100%; padding:11px 15px;
                           border:1.5px solid #e5e7eb; border-radius:10px;
                           font-size:14px; outline:none;
                           font-family:'Outfit',sans-serif;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('deadline')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Project Lead (vous) --}}
            <div style="margin-bottom:25px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:10px;">
                    Project Lead Role
                </label>
                <div style="
                    background:#f5f3ff; border:2px solid #7c3aed;
                    border-radius:12px; padding:15px;
                    display:flex; align-items:center; gap:12px;
                ">
                    <div style="
                        width:40px; height:40px; border-radius:50%;
                        background:linear-gradient(135deg, #7c3aed, #6C63FF);
                        color:white; font-size:16px; font-weight:700;
                        display:flex; align-items:center; justify-content:center;
                    ">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <p style="font-size:14px; font-weight:600; color:#1a1a2e; margin:0;">
                            {{ auth()->user()->name }}
                        </p>
                        <p style="font-size:12px; color:#7c3aed; margin:0;">👑 Lead</p>
                    </div>
                    <span style="margin-left:auto; font-size:20px;">👑</span>
                </div>
                <p style="font-size:12px; color:#94a3b8; margin-top:8px;">
                    💡 You can invite team members after creating the project
                </p>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('projects.index') }}" style="
                    background:#f1f5f9; color:#64748b;
                    padding:11px 24px; border-radius:10px;
                    text-decoration:none; font-weight:600; font-size:14px;
                ">Cancel</a>
                <button type="submit" style="
                    background:#3b82f6; color:white;
                    padding:11px 24px; border-radius:10px;
                    border:none; font-weight:600; font-size:14px;
                    cursor:pointer; font-family:'Outfit',sans-serif;
                "
                onmouseover="this.style.background='#2563eb'"
                onmouseout="this.style.background='#3b82f6'">
                    Create Project
                </button>
            </div>

        </form>
    </div>
</div>

@endsection