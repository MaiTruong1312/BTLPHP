@extends('layouts.app')

@section('title', 'Edit Email Template')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Sửa mẫu Email</h1>
            <p class="text-gray-600">Sử dụng biểu mẫu dưới đây để chỉnh sửa mẫu email.</p>
        </div>
        <a href="{{ route('employer.templates.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">
            Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Rất tiếc!</strong>
            <span class="block sm:inline">Có một số lỗi với đầu vào của bạn.</span>
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('employer.templates.update', $template) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên mẫu</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <p class="mt-2 text-sm text-gray-500">Một tên duy nhất cho mẫu này để bạn có thể dễ dàng xác định nó.</p>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Loại mẫu</label>
                        <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Chọn một loại</option>
                            <option value="interview" {{ old('type', $template->type) == 'interview' ? 'selected' : '' }}>Lời mời phỏng vấn</option>
                            <option value="offered" {{ old('type', $template->type) == 'offered' ? 'selected' : '' }}>Thư mời làm việc</option>
                            <option value="rejected" {{ old('type', $template->type) == 'rejected' ? 'selected' : '' }}>Thư từ chối</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Loại mẫu sẽ giúp phân loại email của bạn.</p>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Tiêu đề</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', $template->subject) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mt-6">
                    <label for="body" class="block text-sm font-medium text-gray-700">Nội dung</label>
                    <textarea name="body" id="body" rows="10" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('body', $template->body) }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Nội dung của email. Bạn có thể sử dụng các biến giữ chỗ sau đây, các biến này sẽ được tự động thay thế:</p>
                    <div class="mt-2 text-sm text-gray-600">
                        <ul>
                            <li><code class="font-mono bg-gray-200 p-1 rounded text-sm">{candidate_name}</code> - Tên của ứng viên</li>
                            <li><code class="font-mono bg-gray-200 p-1 rounded text-sm">{job_title}</code> - Chức danh công việc</li>
                            <li><code class="font-mono bg-gray-200 p-1 rounded text-sm">{company_name}</code> - Tên công ty của bạn</li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="bg-gray-50 px-6 py-3 text-right">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
