@extends('layouts.app')

@section('title', 'Post a New Job')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Post a New Job</h1>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">There were some problems with your input.</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location_id" class="block text-sm font-medium text-gray-700">Location <span class="text-red-500">*</span></label>
                    <select name="location_id" id="location_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select a location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>{{ $location->city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type <span class="text-red-500">*</span></label>
                    <select name="job_type" id="job_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="full_time" @selected(old('job_type') == 'full_time')>Full-time</option>
                        <option value="part_time" @selected(old('job_type') == 'part_time')>Part-time</option>
                        <option value="internship" @selected(old('job_type') == 'internship')>Internship</option>
                        <option value="freelance" @selected(old('job_type') == 'freelance')>Freelance</option>
                        <option value="remote" @selected(old('job_type') == 'remote')>Remote</option>
                    </select>
                </div>

                <!-- Experience Level -->
                <div>
                    <label for="experience_level" class="block text-sm font-medium text-gray-700">Experience Level</label>
                    <select name="experience_level" id="experience_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select level</option>
                        <option value="junior" @selected(old('experience_level') == 'junior')>Junior</option>
                        <option value="mid" @selected(old('experience_level') == 'mid')>Mid-level</option>
                        <option value="senior" @selected(old('experience_level') == 'senior')>Senior</option>
                        <option value="lead" @selected(old('experience_level') == 'lead')>Lead</option>
                    </select>
                </div>

                <!-- Salary -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="salary_min" class="block text-sm font-medium text-gray-700">Salary Min</label>
                        <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="salary_max" class="block text-sm font-medium text-gray-700">Salary Max</label>
                        <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="salary_type" class="block text-sm font-medium text-gray-700">Salary Type <span class="text-red-500">*</span></label>
                        <select name="salary_type" id="salary_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="month" @selected(old('salary_type') == 'month')>Per Month</option>
                            <option value="year" @selected(old('salary_type') == 'year')>Per Year</option>
                            <option value="hour" @selected(old('salary_type') == 'hour')>Per Hour</option>
                            <option value="negotiable" @selected(old('salary_type', 'negotiable') == 'negotiable')>Negotiable</option>
                        </select>
                    </div>
                </div>

                <!-- Vacancies -->
                <div>
                    <label for="vacancies" class="block text-sm font-medium text-gray-700">Vacancies <span class="text-red-500">*</span></label>
                    <input type="number" name="vacancies" id="vacancies" value="{{ old('vacancies', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700">Application Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Is Remote -->
                <div class="md:col-span-2 flex items-center">
                    <input type="checkbox" name="is_remote" id="is_remote" value="1" @checked(old('is_remote')) class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_remote" class="ml-2 block text-sm text-gray-900">This is a remote position</label>
                </div>

                <!-- Skills -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Required Skills</label>
                    <div x-data="skillSelect({
                        allSkills: {{ json_encode($skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])) }},
                        initialSkills: []
                    })" x-init="init()" class="relative mt-1">
                        <template x-for="skill in selectedSkills" :key="skill.id">
                            <input type="hidden" name="skills[]" :value="skill.id">
                        </template>
                        <div class="flex flex-wrap gap-2 mb-2" x-show="selectedSkills.length > 0">
                            <template x-for="skill in selectedSkills" :key="skill.id">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <span x-text="skill.name"></span>
                                    <button @click="removeSkill(skill)" type="button" class="flex-shrink-0 ml-1.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-blue-400 hover:bg-blue-200 hover:text-blue-500 focus:outline-none focus:bg-blue-500 focus:text-white">
                                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" /></svg>
                                    </button>
                                </span>
                            </template>
                        </div>
                        <input x-model="search" @keydown.enter.prevent="addSkillFromSearch()" @keydown.down.prevent="focusNext()" @keydown.up.prevent="focusPrev()" @focus="open = true" @click.away="open = false" type="text" placeholder="Search or add a new skill..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <div x-show="open && filteredSkills.length > 0" class="absolute z-10 w-full mt-1 bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" style="display: none;">
                            <template x-for="(skill, index) in filteredSkills" :key="skill.id">
                                <a href="#" @click.prevent="selectSkill(skill)" :class="{ 'bg-blue-100': index === focusedIndex }" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 block hover:bg-gray-100" x-text="skill.name"></a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                    <textarea name="short_description" id="short_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('short_description') }}</textarea>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Full Job Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                </div>

                <!-- Requirements -->
                <div class="md:col-span-2">
                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                    <textarea name="requirements" id="requirements" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('requirements') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('employer.dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Post Job</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- AlpineJS script cho skill selector, giống hệt như trong trang profile ứng viên --}}
<script>
    function skillSelect(config) {
        return {
            allSkills: config.allSkills || [],
            selectedSkills: [],
            search: '',
            open: false,
            focusedIndex: -1,
            init() {
                this.selectedSkills = config.initialSkills.map(skill => {
                    const existing = this.allSkills.find(s => s.id === skill.id);
                    return existing || { id: skill.name, name: skill.name };
                });
            },
            get filteredSkills() {
                if (this.search === '') return [];
                const searchLower = this.search.toLowerCase();
                return this.allSkills.filter(skill => 
                    skill.name.toLowerCase().includes(searchLower) &&
                    !this.selectedSkills.some(s => s.id === skill.id)
                );
            },
            selectSkill(skill) {
                if (!this.selectedSkills.some(s => s.id === skill.id)) {
                    this.selectedSkills.push(skill);
                }
                this.search = '';
                this.open = false;
                this.focusedIndex = -1;
            },
            removeSkill(skillToRemove) {
                this.selectedSkills = this.selectedSkills.filter(skill => skill.id !== skillToRemove.id);
            },
            addSkillFromSearch() {
                if (this.focusedIndex > -1) {
                    this.selectSkill(this.filteredSkills[this.focusedIndex]);
                    return;
                }
                if (this.search.trim() === '') return;
                const newSkillName = this.search.trim().toLowerCase();
                if (this.selectedSkills.some(s => s.name.toLowerCase() === newSkillName)) {
                    this.search = '';
                    return;
                }
                const existingSkill = this.allSkills.find(s => s.name.toLowerCase() === newSkillName);
                if (existingSkill) {
                    this.selectSkill(existingSkill);
                } else {
                    this.selectSkill({ id: this.search.trim(), name: this.search.trim() });
                }
            },
            focusNext() { if (this.focusedIndex < this.filteredSkills.length - 1) this.focusedIndex++; },
            focusPrev() { if (this.focusedIndex > 0) this.focusedIndex--; },
        }
    }
</script>
@endpush
```

### Bước 3: Cập nhật nút "Post a New Job"

Cuối cùng, hãy cập nhật lại nút "Post a New Job" trong trang Dashboard của nhà tuyển dụng để nó trỏ đến trang tạo việc làm mới.

Mở file `d:\job_portal\resources\views\employer\dashboard.blade.php` và thay đổi dòng sau:

```diff
--- a/d:\job_portal\resources\views\employer\dashboard.blade.php
+++ b/d:\job_portal\resources\views\employer\dashboard.blade.php