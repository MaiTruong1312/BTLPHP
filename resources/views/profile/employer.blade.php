@extends('layouts.app')

@section('title', 'Company Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Company Profile</h1>

    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Avatar Update Form with Preview and Cropper -->
        <div x-data="avatarCropper()" class="mb-8 pb-8 border-b">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Your Profile Picture</h3>
            <div class="flex items-center space-x-6">
                <img class="h-12 w-12 rounded-full object-cover" :src="avatarPreview" alt="{{ auth()->user()->name }}">
                
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

        <form action="{{ route('profile.update.employer') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $user->employerProfile->company_name ?? '') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="website" class="block text-gray-700 text-sm font-bold mb-2">Website</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $user->employerProfile->website ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->employerProfile->phone ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mb-6">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->employerProfile->address ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label for="company_size" class="block text-gray-700 text-sm font-bold mb-2">Company Size</label>
                <select name="company_size" id="company_size" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Company Size</option>
                    <option value="1-10" {{ old('company_size', $user->employerProfile->company_size ?? '') == '1-10' ? 'selected' : '' }}>1-10</option>
                    <option value="11-50" {{ old('company_size', $user->employerProfile->company_size ?? '') == '11-50' ? 'selected' : '' }}>11-50</option>
                    <option value="51-200" {{ old('company_size', $user->employerProfile->company_size ?? '') == '51-200' ? 'selected' : '' }}>51-200</option>
                    <option value="201-500" {{ old('company_size', $user->employerProfile->company_size ?? '') == '201-500' ? 'selected' : '' }}>201-500</option>
                    <option value="501-1000" {{ old('company_size', $user->employerProfile->company_size ?? '') == '501-1000' ? 'selected' : '' }}>501-1000</option>
                    <option value="1000+" {{ old('company_size', $user->employerProfile->company_size ?? '') == '1000+' ? 'selected' : '' }}>1000+</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="about" class="block text-gray-700 text-sm font-bold mb-2">About Company</label>
                <textarea name="about" id="about" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('about', $user->employerProfile->about ?? '') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Company Logo</label>
                <input type="file" name="logo" id="logo" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @if($user->employerProfile && $user->employerProfile->logo)
                    <p class="text-sm text-gray-500 mt-1">Current logo: <img src="{{ asset('storage/' . $user->employerProfile->logo) }}" alt="Logo" class="h-16 mt-2"></p>
                @endif
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                Update Profile
            </button>
        </form>
    </div>
</div>
@endsection

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
@endpush
