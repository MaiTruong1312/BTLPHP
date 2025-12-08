{{-- Check if it's modal or full page --}}
@if(!isset($isModal) || !$isModal)
    @extends('layouts.app')
    @section('title', 'Gửi Email tới ' . $application->user->name)
    @section('content')
@endif

<div class="{{ isset($isModal) && $isModal ? '' : 'max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10' }}"
     x-data="{ selectedTemplate: '' }">

    {{-- PAGE HEADER (full page only) --}}
    @if(!isset($isModal))
    <div class="mb-8">
        <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-lg text-white">
            <h1 class="text-3xl font-extrabold tracking-tight">✉️ Gửi Email cho Ứng viên</h1>
            <p class="text-blue-100 mt-1">
                Tới <span class="font-bold">{{ $application->user->name }}</span>
                — Vị trí: <span class="font-medium">{{ $application->job->title }}</span>
            </p>
        </div>
    </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 backdrop-blur-sm">

        <form action="{{ route('employer.applications.sendEmail', $application->id) }}" method="POST">
            @csrf

            <input type="hidden" name="application_id_for_validation" value="{{ $application->id }}">

            {{-- TITLE --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    📧 Email tới <span class="text-blue-600">{{ $application->user->name }}</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">Công việc: {{ $application->job->title }}</p>
            </div>

            {{-- TEMPLATE SELECTOR --}}
            <div class="mb-6">
                <div class="flex justify-between items-center mb-1">
                    <label for="template" class="block text-sm font-semibold text-gray-800">Chọn mẫu email</label>
                    <a href="{{ route('employer.templates.index') }}" target="_blank"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                        Quản lý mẫu <span>↗</span>
                    </a>
                </div>

                <select id="template"
                        x-model="selectedTemplate"
                        @change="
                            if (selectedTemplate) {
                                const t = JSON.parse(selectedTemplate);
                                const name = '{{ addslashes($application->user->name) }}';
                                const job = '{{ addslashes($application->job->title) }}';
                                const company = '{{ addslashes($application->job->employerProfile->company_name ?? '') }}';

                                $refs.subject.value = t.subject
                                    .replace(/{candidate_name}/g, name)
                                    .replace(/{job_title}/g, job)
                                    .replace(/{company_name}/g, company);

                                $refs.body.value = t.body
                                    .replace(/{candidate_name}/g, name)
                                    .replace(/{job_title}/g, job)
                                    .replace(/{company_name}/g, company);
                            } else {
                                $refs.subject.value = '';
                                $refs.body.value = '';
                            }
                        "
                        class="w-full px-4 py-2 border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm hover:bg-gray-100 transition">
                    <option value="">-- Soạn thủ công --</option>
                    @foreach($templates as $template)
                        <option value="{{ json_encode($template) }}">
                            {{ $template->name }} ({{ ucfirst($template->type) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SUBJECT --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-1">Tiêu đề</label>
                <input type="text" name="subject" x-ref="subject"
                       value="{{ old('subject') }}"
                       required
                       class="w-full px-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror">
                @error('subject') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- BODY --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nội dung</label>
                <textarea name="body" rows="12" x-ref="body" required
                          class="w-full p-3 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- PLACEHOLDER GUIDE --}}
            <div class="bg-gray-50 p-5 rounded-xl border text-sm text-gray-700 mb-8">
                <p class="font-semibold mb-2">✨ Mẹo viết email nhanh:</p>
                <p>Bạn có thể dùng các biến sau trong Tiêu đề / Nội dung:</p>

                <ul class="mt-2 space-y-2">
                    <li>
                        <code class="bg-gray-200 py-1 px-2 rounded text-sm">{candidate_name}</code> → Tên ứng viên
                    </li>
                    <li>
                        <code class="bg-gray-200 py-1 px-2 rounded text-sm">{job_title}</code> → Tên công việc
                    </li>
                    <li>
                        <code class="bg-gray-200 py-1 px-2 rounded text-sm">{company_name}</code> → Tên công ty
                    </li>
                </ul>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-end gap-4">

                {{-- Nếu là modal --}}
                @if(isset($isModal) && $isModal)
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-100">
                        Hủy
                    </button>
                @else
                    <a href="{{ url()->previous() }}"
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-100">
                        ← Quay lại
                    </a>
                @endif

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 font-medium transition transform hover:-translate-y-0.5">
                    ✉️ Gửi Email
                </button>
            </div>

        </form>
    </div>
</div>

@if(!isset($isModal) || !$isModal)
    @endsection
@endif
