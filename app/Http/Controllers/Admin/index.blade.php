@extends('layouts.app') {{-- Giả sử bạn có một layout chung là app.blade.php --}}

@section('title', 'Quản lý Đơn ứng tuyển')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Đơn ứng tuyển</h1>
            <p class="text-gray-600">Quản lý các ứng viên cho tin tuyển dụng của bạn.</p>
        </div>
    </div>

    {{-- Form Lọc và Tìm kiếm --}}
    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('employer.applications.index') }}" class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên công việc, ứng viên..." class="border rounded-lg px-4 py-2 md:col-span-2 focus:ring-blue-500 focus:border-blue-500">
            <select name="status" class="border rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Tất cả trạng thái</option>
                @foreach(['reviewing' => 'Đang xem xét', 'interview' => 'Hẹn phỏng vấn', 'offered' => 'Mời nhận việc', 'rejected' => 'Đã từ chối'] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700 transition duration-200">Lọc</button>
        </form>
    </div>

    {{-- Bảng danh sách đơn ứng tuyển --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ứng viên</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vị trí ứng tuyển</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày ứng tuyển</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $application->user->avatar ? asset('storage/' . $application->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($application->user->name) }}" alt="{{ $application->user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $application->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('jobs.show', $application->job->slug) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800" target="_blank">
                                {{ $application->job->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('employer.applications.updateStatus', $application->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                                    @foreach(['reviewing' => 'Đang xem xét', 'interview' => 'Hẹn phỏng vấn', 'offered' => 'Mời nhận việc', 'rejected' => 'Từ chối'] as $value => $label)
                                        <option value="{{ $value }}" {{ $application->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->applied_at?->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ $application->cv_path ? asset('storage/' . $application->cv_path) : '#' }}" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank" @if(!$application->cv_path) onclick="alert('Ứng viên chưa nộp CV.'); return false;" @endif>Xem CV</a>
                            <form action="{{ route('employer.applications.destroy', $application->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn ứng tuyển này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Chưa có đơn ứng tuyển nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection