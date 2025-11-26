@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Update Your Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Avatar Update Form with Preview -->
        <div x-data="avatarCropper()" class="mb-8 pb-8 border-b">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Profile Picture</h3>
            <div class="flex items-center space-x-6">
                <img class="h-24 w-24 rounded-full object-cover" :src="avatarPreview" alt="{{ auth()->user()->name }}">
                
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="avatar_base64" x-model="croppedAvatar">
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700">Change Avatar</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <input id="avatar" name="avatar" type="file" @change="handleFileSelect" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <button type="submit" :disabled="!croppedAvatar" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-sm hover:shadow-md disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Upload
                            </button>
                        </div>
                        @error('avatar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('avatar_base64')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Cropper Modal -->
            <div x-show="showCropper" @keydown.escape.window="showCropper = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" style="display: none;">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg" @click.away="showCropper = false">
                    <h3 class="text-lg font-medium mb-4">Crop Your Image</h3>
                    <div class="max-h-[60vh]">
                        <img x-ref="imageToCrop" src="" class="max-w-full">
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" @click="showCropper = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                        <button type="button" @click="cropImage" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Crop & Apply</button>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-xl font-bold text-gray-900 mb-4">Personal Information</h3>
        <form action="{{ route('profile.update.candidate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->candidateProfile?->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', optional($user->candidateProfile?->date_of_birth)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="male" @selected(old('gender', $user->candidateProfile?->gender) == 'male')>Male</option>
                        <option value="female" @selected(old('gender', $user->candidateProfile?->gender) == 'female')>Female</option>
                        <option value="other" @selected(old('gender', $user->candidateProfile?->gender) == 'other')>Other</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->candidateProfile?->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Years of Experience -->
                <div>
                    <label for="years_of_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                    <input type="number" name="years_of_experience" id="years_of_experience" value="{{ old('years_of_experience', $user->candidateProfile?->years_of_experience) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Expected Salary -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="expected_salary_min" class="block text-sm font-medium text-gray-700">Expected Salary (Min)</label>
                        <input type="number" name="expected_salary_min" id="expected_salary_min" value="{{ old('expected_salary_min', $user->candidateProfile?->expected_salary_min) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="expected_salary_max" class="block text-sm font-medium text-gray-700">Expected Salary (Max)</label>
                        <input type="number" name="expected_salary_max" id="expected_salary_max" value="{{ old('expected_salary_max', $user->candidateProfile?->expected_salary_max) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Skills -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Skills</label>
                    <div x-data="skillSelect({
                        allSkills: {{ json_encode($skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name])) }},
                        initialSkills: {{ json_encode($user->candidateProfile?->skills->map(fn($s) => ['id' => $s->id, 'name' => $s->name]) ?? []) }}
                    })" x-init="init()" class="relative mt-1">
                        
                        <!-- Hidden inputs for submission -->
                        <template x-for="skill in selectedSkills" :key="skill.id">
                            <input type="hidden" name="skills[]" :value="skill.id">
                        </template>

                        <!-- Display selected skills -->
                        <div class="flex flex-wrap gap-2 mb-2" x-show="selectedSkills.length > 0">
                            <template x-for="skill in selectedSkills" :key="skill.id">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <span x-text="skill.name"></span>
                                    <button @click="removeSkill(skill)" type="button" class="flex-shrink-0 ml-1.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-blue-400 hover:bg-blue-200 hover:text-blue-500 focus:outline-none focus:bg-blue-500 focus:text-white">
                                        <span class="sr-only">Remove skill</span>
                                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                        </svg>
                                    </button>
                                </span>
                            </template>
                        </div>

                        <!-- Input field -->
                        <input 
                            x-model="search"
                            @keydown.enter.prevent="addSkillFromSearch()"
                            @keydown.down.prevent="focusNext()"
                            @keydown.up.prevent="focusPrev()"
                            @focus="open = true"
                            @click.away="open = false"
                            type="text"
                            placeholder="Search or add a new skill..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >

                        <!-- Dropdown -->
                        <div x-show="open && filteredSkills.length > 0" 
                             class="absolute z-10 w-full mt-1 bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                             style="display: none;">
                            <template x-for="(skill, index) in filteredSkills" :key="skill.id">
                                <a href="#" 
                                   @click.prevent="selectSkill(skill)"
                                   :class="{ 'bg-blue-100': index === focusedIndex }"
                                   class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 block hover:bg-gray-100"
                                   x-text="skill.name">
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="md:col-span-2">
                    <label for="summary" class="block text-sm font-medium text-gray-700">Summary</label>
                    <textarea name="summary" id="summary" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('summary', $user->candidateProfile?->summary) }}</textarea>
                </div>

                <!-- CV Upload -->
                <div class="md:col-span-2">
                    <label for="cv" class="block text-sm font-medium text-gray-700">Upload CV</label>
                    <input type="file" name="cv" id="cv" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @if($user->candidateProfile?->cv_path)
                        <p class="text-sm text-gray-500 mt-2">Current CV: <a href="{{ asset('storage/' . $user->candidateProfile->cv_path) }}" target="_blank" class="text-blue-600 hover:underline">View CV</a></p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Work Experience Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mt-8">
        <h2 class="text-2xl font-bold mb-4">Work Experience</h2>
        
        <!-- List of existing experiences -->
        <div class="space-y-4 mb-6">
            @forelse($user->candidateProfile?->experiences ?? [] as $experience)
                <div x-data="{ editing: false }" class="border p-4 rounded-md">
                    <!-- Display View -->
                    <div x-show="!editing">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $experience->position }} at {{ $experience->company_name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Present' : \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                </p>
                                <p class="text-gray-600 mt-2">{{ $experience->description }}</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <button @click="editing = true" class="text-blue-500 hover:text-blue-700 font-semibold mr-4">Edit</button>
                                <form action="{{ route('profile.experience.destroy', $experience->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this experience?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Form -->
                    <div x-show="editing" style="display: none;">
                        <form action="{{ route('profile.experience.update', $experience->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700">Company Name</label><input type="text" name="company_name" value="{{ $experience->company_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                                <div><label class="block text-sm font-medium text-gray-700">Position</label><input type="text" name="position" value="{{ $experience->position }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                                <div><label class="block text-sm font-medium text-gray-700">Start Date</label><input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($experience->start_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                                <div><label class="block text-sm font-medium text-gray-700">End Date</label><input type="date" name="end_date" value="{{ optional($experience->end_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700">Description</label><textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $experience->description }}</textarea></div>
                                <div class="md:col-span-2 flex items-center"><input type="checkbox" name="is_current" value="1" @checked($experience->is_current) class="h-4 w-4 text-blue-600 border-gray-300 rounded"><label class="ml-2 block text-sm text-gray-900">I currently work here</label></div>
                            </div>
                            <div class="mt-4 flex items-center gap-4">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                                <button type="button" @click="editing = false" class="text-gray-600 hover:text-gray-800">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">No work experience added yet.</p>
            @endforelse
        </div>

        <!-- Form to add new experience -->
        <h3 class="text-xl font-bold mb-4 border-t pt-6">Add New Experience</h3>
        <form action="{{ route('profile.experience.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <input type="text" name="position" id="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="exp_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="exp_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="exp_end_date" class="block text-sm font-medium text-gray-700">End Date (leave blank if current)</label>
                    <input type="date" name="end_date" id="exp_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="exp_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="exp_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Add Experience</button>
            </div>
        </form>
    </div>

    <!-- Education Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mt-8">
        <h2 class="text-2xl font-bold mb-4">Education</h2>

        <!-- List of existing educations -->
        <div class="space-y-4 mb-6">
            @forelse($user->candidateProfile?->educations ?? [] as $education)
                <div x-data="{ editing: false }" class="border p-4 rounded-md">
                    <!-- Display View -->
                    <div x-show="!editing">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $education->degree }} in {{ $education->field_of_study }}</h3>
                                <p class="text-md text-gray-700">{{ $education->school_name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} - 
                                    {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('M Y') : 'Present' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <button @click="editing = true" class="text-blue-500 hover:text-blue-700 font-semibold mr-4">Edit</button>
                                <form action="{{ route('profile.education.destroy', $education->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this education entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Form -->
                    <div x-show="editing" style="display: none;">
                        <form action="{{ route('profile.education.update', $education->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-sm font-medium text-gray-700">School Name</label><input type="text" name="school_name" value="{{ $education->school_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                                <div><label class="block text-sm font-medium text-gray-700">Degree</label><input type="text" name="degree" value="{{ $education->degree }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                                <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700">Field of Study</label><input type="text" name="field_of_study" value="{{ $education->field_of_study }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                                <div><label class="block text-sm font-medium text-gray-700">Start Date</label><input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($education->start_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></div>
                                <div><label class="block text-sm font-medium text-gray-700">End Date</label><input type="date" name="end_date" value="{{ optional($education->end_date)->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></div>
                            </div>
                            <div class="mt-4 flex items-center gap-4">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
                                <button type="button" @click="editing = false" class="text-gray-600 hover:text-gray-800">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No education history added yet.</p>
            @endforelse
        </div>

        <!-- Form to add new education -->
        <h3 class="text-xl font-bold mb-4 border-t pt-6">Add New Education</h3>
        <form action="{{ route('profile.education.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="school_name" class="block text-sm font-medium text-gray-700">School Name</label>
                    <input type="text" name="school_name" id="school_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="degree" class="block text-sm font-medium text-gray-700">Degree</label>
                    <input type="text" name="degree" id="degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="field_of_study" class="block text-sm font-medium text-gray-700">Field of Study</label>
                    <input type="text" name="field_of_study" id="field_of_study" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="edu_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="edu_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="edu_end_date" class="block text-sm font-medium text-gray-700">End Date (leave blank if ongoing)</label>
                    <input type="date" name="end_date" id="edu_end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Add Education</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<!-- Styles for the new skill selector are handled by Tailwind CSS, no extra styles needed. -->
@endpush

@push('scripts')
<script>
    function avatarCropper() {
        return {
            avatarPreview: '{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}',
            showCropper: false,
            cropper: null,
            croppedAvatar: '',

            handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.$refs.imageToCrop.src = e.target.result;
                    this.showCropper = true;
                    this.$nextTick(() => {
                        if (this.cropper) {
                            this.cropper.destroy();
                        }
                        this.cropper = new Cropper(this.$refs.imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 2,
                            autoCropArea: 0.9,
                        });
                    });
                };
                reader.readAsDataURL(file);
            },

            cropImage() {
                const canvas = this.cropper.getCroppedCanvas({
                    width: 256,
                    height: 256,
                });
                this.avatarPreview = canvas.toDataURL('image/jpeg');
                this.croppedAvatar = this.avatarPreview;
                this.showCropper = false;
            }
        }
    }
</script>
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
                    return existing || { id: skill.name, name: skill.name }; // Handle new tags
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
                
                // Prevent adding duplicate skill
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
