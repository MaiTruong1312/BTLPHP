@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Edit Job</h1>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('jobs.update', $job) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Job Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category *</label>
                    <select name="category_id" id="category_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="location_id" class="block text-gray-700 text-sm font-bold mb-2">Location *</label>
                    <select name="location_id" id="location_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $job->location_id) == $location->id ? 'selected' : '' }}>{{ $location->city }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="short_description" class="block text-gray-700 text-sm font-bold mb-2">Short Description</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $job->short_description) }}" maxlength="255" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Job Description *</label>
                <textarea name="description" id="description" rows="8" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="requirements" class="block text-gray-700 text-sm font-bold mb-2">Requirements</label>
                <textarea name="requirements" id="requirements" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('requirements', $job->requirements) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="salary_min" class="block text-gray-700 text-sm font-bold mb-2">Salary Min</label>
                    <input type="number" name="salary_min" id="salary_min" value="{{ old('salary_min', $job->salary_min) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="salary_max" class="block text-gray-700 text-sm font-bold mb-2">Salary Max</label>
                    <input type="number" name="salary_max" id="salary_max" value="{{ old('salary_max', $job->salary_max) }}" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Currency *</label>
                    <input type="text" name="currency" id="currency" value="{{ old('currency', $job->currency) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="salary_type" class="block text-gray-700 text-sm font-bold mb-2">Salary Type *</label>
                    <select name="salary_type" id="salary_type" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="month" {{ old('salary_type', $job->salary_type) == 'month' ? 'selected' : '' }}>Per Month</option>
                        <option value="year" {{ old('salary_type', $job->salary_type) == 'year' ? 'selected' : '' }}>Per Year</option>
                        <option value="hour" {{ old('salary_type', $job->salary_type) == 'hour' ? 'selected' : '' }}>Per Hour</option>
                        <option value="negotiable" {{ old('salary_type', $job->salary_type) == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="job_type" class="block text-gray-700 text-sm font-bold mb-2">Job Type *</label>
                    <select name="job_type" id="job_type" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="full_time" {{ old('job_type', $job->job_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('job_type', $job->job_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="internship" {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        <option value="freelance" {{ old('job_type', $job->job_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                        <option value="remote" {{ old('job_type', $job->job_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                    </select>
                </div>
                <div>
                    <label for="experience_level" class="block text-gray-700 text-sm font-bold mb-2">Experience Level</label>
                    <select name="experience_level" id="experience_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Level</option>
                        <option value="junior" {{ old('experience_level', $job->experience_level) == 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="mid" {{ old('experience_level', $job->experience_level) == 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="senior" {{ old('experience_level', $job->experience_level) == 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="lead" {{ old('experience_level', $job->experience_level) == 'lead' ? 'selected' : '' }}>Lead</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="vacancies" class="block text-gray-700 text-sm font-bold mb-2">Number of Vacancies *</label>
                    <input type="number" name="vacancies" id="vacancies" value="{{ old('vacancies', $job->vacancies) }}" min="1" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Application Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_remote" value="1" {{ old('is_remote', $job->is_remote) ? 'checked' : '' }} class="form-checkbox">
                    <span class="ml-2 text-gray-700">Remote Work Available</span>
                </label>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="published" {{ old('status', $job->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $job->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="skills" class="block text-gray-700 text-sm font-bold mb-2">Required Skills</label>
                <select name="skills[]" id="skills" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" size="5">
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" {{ in_array($skill->id, old('skills', $job->skills->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $skill->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd on Mac) to select multiple skills</p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Update Job
                </button>
                <a href="{{ route('jobs.show', $job->slug) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

