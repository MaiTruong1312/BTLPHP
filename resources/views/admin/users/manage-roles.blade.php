@extends('layouts.app')

@section('title', 'Manage User Roles')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage User Roles</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filters and Bulk Actions -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <form id="bulk-action-form" action="{{ route('admin.users.bulk-update-roles') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filter Form -->
                <div class="md:col-span-2">
                    <form action="{{ route('admin.users.manage-roles') }}" method="GET" class="flex items-center space-x-4">
                        <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="form-input w-full rounded-md shadow-sm">
                        <select name="role" class="form-select rounded-md shadow-sm">
                            <option value="">All Roles</option>
                            <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                            <option value="employer" @selected(request('role') == 'employer')>Employer</option>
                            <option value="candidate" @selected(request('role') == 'candidate')>Candidate</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>

                <!-- Bulk Action -->
                <div>
                    <div class="flex items-center space-x-2">
                        <select name="role" required class="form-select w-full rounded-md shadow-sm">
                            <option value="" disabled selected>Set role to...</option>
                            <option value="admin">Admin</option>
                            <option value="employer">Employer</option>
                            <option value="candidate">Candidate</option>
                        </select>
                        <button type="submit" class="btn btn-secondary whitespace-nowrap">Apply to Selected</button>
                    </div>
                </div>
            </div>

            <!-- User Table -->
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="p-4">
                                <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-indigo-600">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="p-4">
                                    @if($user->id !== auth()->id())
                                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="form-checkbox h-5 w-5 text-indigo-600 user-checkbox">
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'employer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $users->links() }}
    </div>
</div>

<script>
    document.getElementById('select-all').addEventListener('click', function(event) {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = event.target.checked;
        });
    });
</script>
@endsection