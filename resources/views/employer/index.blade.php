@extends('layouts.app')

@section('title', 'Quản lý Đơn ứng tuyển')

@section('content')
<div 
    class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 relative"
    x-data="{ 
        isNotesModalOpen: false,
        isCoverLetterModalOpen: false, 
        isInterviewModalOpen: false,
        currentApplicationId: null, 
        currentNotes: '', 
        currentCoverLetter: '', 
        currentApplicantName: '', 
        currentApplicantEmail: '' 
    }"
>

    {{-- Soft Background Glow --}}
    <div class="absolute inset-0 -z-10 opacity-30">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200 blur-3xl rounded-full"></div>
        <div class="absolute top-1/3 -right-20 w-64 h-64 bg-purple-200 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 left-1/3 w-72 h-72 bg-indigo-200 blur-3xl rounded-full"></div>
    </div>

    {{-- HEADER --}}
    <div class="mb-10">
        <div class="p-8 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white shadow-lg">
            <h1 class="text-4xl font-extrabold tracking-tight">📄 Đơn Ứng Tuyển</h1>
            <p class="text-blue-100 mt-1">Quản lý các ứng viên đang ứng tuyển công việc của bạn.</p>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-6 mt-6 text-center">
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl">
                    <p class="text-2xl font-bold">{{ $applications->total() }}</p>
                    <p class="text-sm text-blue-100">Tổng đơn ứng tuyển</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl">
                    <p class="text-2xl font-bold">{{ $applications->where('status', 'reviewing')->count() }}</p>
                    <p class="text-sm text-blue-100">Đang xem xét</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl">
                    <p class="text-2xl font-bold">{{ $applications->where('status', 'interview')->count() }}</p>
                    <p class="text-sm text-blue-100">Đã hẹn phỏng vấn</p>
                </div>
            </div>
        </div>
    </div>


    {{-- FILTERS --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 mb-10 backdrop-blur-sm">

        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            🔎 Lọc & Tìm kiếm 
        </h2>

        <form method="GET" action="{{ route('employer.applications.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">

            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="🔍 Tìm theo tên ứng viên, công việc..."
                   class="border rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50">

            {{-- JOB SELECT --}}
            <select name="job_id" class="border rounded-lg px-4 py-2 bg-gray-50 focus:ring-blue-500">
                <option value="">📌 Tất cả công việc</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>{{ $job->title }}</option>
                @endforeach
            </select>

            {{-- STATUS SELECT --}}
            <select name="status" class="border rounded-lg px-4 py-2 bg-gray-50 focus:ring-blue-500">
                <option value="">📍 Tất cả trạng thái</option>
                @foreach([
                    'applied' => 'Mới ứng tuyển', 
                    'reviewing' => 'Đang xem xét', 
                    'interview' => 'Hẹn phỏng vấn', 
                    'offered' => 'Mời nhận việc', 
                    'rejected' => 'Đã từ chối'
                ] as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700 transition">
                Lọc kết quả
            </button>
        </form>
    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ứng viên</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Vị trí</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ghi chú</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Ngày gửi</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- APPLICANT --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img class="h-12 w-12 rounded-full shadow object-cover"
                                     src="{{ $application->user->avatar ? asset('storage/' . $application->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($application->user->name) }}">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $application->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- JOB --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('jobs.show', $application->job->slug) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                {{ $application->job->title }}
                            </a>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- Sử dụng route update-status của JobApplicationController để xử lý logic interview --}}
                            <form method="POST" action="{{ route('applications.update-status', $application->id) }}">
                                @csrf @method('PATCH')

                                <select name="status"
                                        class="px-3 py-1.5 rounded-lg border focus:ring-blue-500 text-sm bg-white shadow-sm"
                                        x-on:change="
                                            if ($event.target.value === 'interview') {
                                                isInterviewModalOpen = true;
                                                currentApplicationId = {{ $application->id }};
                                                $event.target.value = '{{ $application->status }}'; // Reset visual value until saved
                                            } else {
                                                $event.target.form.submit();
                                            }
                                        "
                                >
                                    @foreach([
                                        'reviewing' => 'Đang xem xét', 
                                        'interview' => 'Hẹn phỏng vấn', 
                                        'offered' => 'Mời nhận việc', 
                                        'rejected' => 'Từ chối'
                                    ] as $value => $label)
                                        <option value="{{ $value }}" {{ $application->status === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>

                            </form>
                        </td>

                        {{-- NOTES --}}
                        <td class="px-6 py-4 whitespace-normal">
                            <div 
                                @click="
                                    isNotesModalOpen = true; 
                                    currentApplicationId = {{ $application->id }};
                                    currentNotes = '{{ e($application->notes) }}';
                                    currentApplicantName = '{{ e($application->user->name) }}';
                                    currentApplicantEmail = '{{ e($application->user->email) }}';
                                " 
                                class="cursor-pointer p-2 rounded hover:bg-gray-100 transition text-gray-600"
                            >
                                <p class="line-clamp-2 text-sm">
                                    {{ $application->notes ?: '📝 Thêm ghi chú...' }}
                                </p>
                            </div>
                        </td>

                        {{-- DATE --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $application->applied_at?->format('d/m/Y H:i') }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">

                            @if($application->candidateProfile)
                                <a href="{{ route('profile.public.show', $application->user->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Hồ sơ</a>
                            @endif

                            @if($application->cv_path)
                                <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-medium">CV</a>
                            @endif

                            <a href="{{ route('employer.applications.email.show', $application->id) }}" class="text-green-600 hover:text-green-900 font-medium">
                                Email
                            </a>

                            @if($application->cover_letter)
                                <button
                                    @click="
                                        isCoverLetterModalOpen = true;
                                        currentCoverLetter = `{{ e($application->cover_letter) }}`;
                                        currentApplicantName = '{{ e($application->user->name) }}';
                                        currentApplicantEmail = '{{ e($application->user->email) }}';
                                    "
                                    class="text-purple-600 hover:text-purple-900 font-medium"
                                >
                                    Cover Letter
                                </button>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-lg">
                            Không có đơn ứng tuyển nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $applications->links() }}
    </div>


    {{-- MODAL — NOTES --}}
    <div 
        x-show="isNotesModalOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4"
        x-cloak
    >
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden" @click.away="isNotesModalOpen = false">

            <form :action="'/employer/applications/' + currentApplicationId + '/notes'" method="POST">
                @csrf @method('PATCH')

                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">📝 Ghi chú cho ứng viên</h3>

                    <div class="mt-3 bg-gray-50 border rounded-lg p-3">
                        <p class="font-semibold" x-text="currentApplicantName"></p>
                        <p class="text-sm text-gray-500" x-text="currentApplicantEmail"></p>
                    </div>
                </div>

                <div class="p-6">
                    <textarea name="notes" x-model="currentNotes" rows="8"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3"
                              placeholder="Nhập ghi chú..."></textarea>
                </div>

                <div class="flex justify-end gap-3 bg-gray-50 px-6 py-3">
                    <button type="button"
                            @click="isNotesModalOpen = false"
                            class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        Hủy
                    </button>
                    <button type="submit"
                            class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Lưu
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- MODAL — COVER LETTER --}}
    <div 
        x-show="isCoverLetterModalOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4"
        x-cloak
    >
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden flex flex-col" @click.away="isCoverLetterModalOpen = false">

            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold">📄 Cover Letter</h3>
                <p class="font-semibold mt-2" x-text="currentApplicantName"></p>
                <p class="text-sm text-gray-500" x-text="currentApplicantEmail"></p>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <p class="text-gray-700 whitespace-pre-wrap" x-text="currentCoverLetter"></p>
            </div>

            <div class="bg-gray-50 px-6 py-3">
                <button @click="isCoverLetterModalOpen = false"
                        class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    Đóng
                </button>
            </div>

        </div>
    </div>

    {{-- MODAL — INTERVIEW SCHEDULE --}}
    <div 
        x-show="isInterviewModalOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4"
        x-cloak
    >
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.away="isInterviewModalOpen = false">
            
            {{-- Form trỏ về route xử lý logic tạo lịch phỏng vấn --}}
            <form :action="'/applications/' + currentApplicationId + '/update-status'" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="interview">

                <div class="p-6 border-b bg-indigo-600 text-white">
                    <h3 class="text-lg font-bold">📅 Lên lịch phỏng vấn</h3>
                    <p class="text-indigo-100 text-sm">Thiết lập cuộc hẹn với ứng viên.</p>
                </div>

                <div class="p-6 space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thời gian bắt đầu <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" required
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hình thức</label>
                            <select name="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="online">Online (Meet/Zoom)</option>
                                <option value="offline">Offline (Tại văn phòng)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Thời lượng (phút)</label>
                            <input type="number" name="duration_minutes" value="60" min="15" step="15"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa điểm / Link họp <span class="text-red-500">*</span></label>
                        <input type="text" name="location" required placeholder="VD: Google Meet Link hoặc Phòng họp 2"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú / Dặn dò</label>
                        <textarea name="notes" rows="3" placeholder="Mang theo laptop, portfolio..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 bg-gray-50 px-6 py-3">
                    <button type="button" @click="isInterviewModalOpen = false" class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Hủy</button>
                    <button type="submit" class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium">Xác nhận lịch hẹn</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
