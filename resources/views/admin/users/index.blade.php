@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Users</h1>
            <p class="text-gray-600">Manage all platform users</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email" class="border rounded-lg px-4 py-2">
            <select name="role" class="border rounded-lg px-4 py-2">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employer" {{ request('role') === 'employer' ? 'selected' : '' }}>Employer</option>
                <option value="candidate" {{ request('role') === 'candidate' ? 'selected' : '' }}>Candidate</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="inline-flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employer" {{ $user->role === 'employer' ? 'selected' : '' }}>Employer</option>
                                    <option value="candidate" {{ $user->role === 'candidate' ? 'selected' : '' }}>Candidate</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at?->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
