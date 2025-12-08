<div class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <div class="mb-8">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
            <svg class="h-8 w-8 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-2xl font-bold">Admin</span>
        </a>
    </div>
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                    Manage Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.jobs.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.jobs.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                    Manage Jobs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.applications.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.applications.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                    Manage Applications
                </a>
            </li>
             <li>
                <div class="pt-2 mt-2 border-t border-gray-700">
                    <a href="{{ route('home') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Site
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</div>
