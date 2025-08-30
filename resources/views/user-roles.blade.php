@extends('layouts.app')
@section('title', 'User Role Management')
@section('content')
<div style="max-width: 64rem; margin: 0 auto; padding: 2.5rem 1.5rem;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 1.5rem;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">User Role Management</h2>

        <!-- Display Success or Error Messages -->
        <div style="background-color: #d1fae5; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
            <!-- Placeholder for success message -->
        </div>
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; display: none;">
            <ul style="margin: 0; padding-left: 1rem;">
                <!-- Placeholder for error messages -->
            </ul>
        </div>

        <!-- Form -->
        <form class="mb-8" style="margin-bottom: 2rem;">
            <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;" class="md:flex-row">
                <div style="width: 100%; max-width: 75%;">
                    <label for="userRole" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Enter User Role</label>
                    <input type="text" id="userRole" name="role" required
                        style="width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; box-sizing: border-box;">
                </div>
                <div style="width: 100%; max-width: 25%; margin-top: 1rem;" class="md:mt-0">
                    <button type="submit"
                        style="width: 100%; background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                        <i class="fa-solid fa-plus-circle" style="margin-right: 0.25rem;"></i> Add
                    </button>
                </div>
            </div>
        </form>

        <!-- Search Bar -->
        <form style="margin-bottom: 1rem; display: flex; justify-content: flex-start; align-items: center; gap: 0.5rem;">
            <input type="text" name="search" id="searchInput" placeholder="Search User Role..."
                style="border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem 0.75rem; width: 100%; max-width: 300px; outline: none;">
            <button type="submit"
                style="background-color: #f97316; color: white; border: none; border-radius: 0.375rem; padding: 0.4rem 0.8rem; cursor: pointer; font-size: 0.875rem;">
                🔍
            </button>
        </form>

        <!-- Table -->
        <div style="overflow-x: auto;">
            <table id="roleTable"
                style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <thead style="background-color: #f97316; color: white; cursor: pointer;">
                    <tr>
                        <th style="padding: 0.75rem;">User Role ▲▼</th>
                        <th style="padding: 0.75rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" style="margin-top: 1rem; text-align: center;">
            <button style="margin: 0 0.25rem; padding: 0.25rem 0.75rem; background: #f97316; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">1</button>
        </div>
    </div>
</div>
@endsection