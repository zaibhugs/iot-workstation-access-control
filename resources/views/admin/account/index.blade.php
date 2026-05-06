@extends('layout.app')

@section('title','Account')

@section('content')

{{--
    IMPORTANT: The form wraps the entire grid.
    enctype="multipart/form-data" is required for file uploads.
--}}
<form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Profile Picture --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 sticky top-20">

                {{-- Profile Picture Upload Area --}}
                <div class="mb-6">
                    <label for="profile_image" class="relative w-full aspect-square bg-neutral-primary-medium border-2 border-dashed border-default rounded-lg flex items-center justify-center overflow-hidden group cursor-pointer hover:bg-neutral-secondary-medium transition">

                        {{-- UPDATED: Changed from profile_picture to profile_pic --}}
                        <img id="image_preview"
                            src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : '' }}"
                            class="absolute inset-0 w-full h-full object-cover {{ $user->profile_pic ? '' : 'hidden' }}">

                        {{-- UPDATED: Placeholder hidden if profile_pic exists --}}
                        <div id="upload_placeholder" class="text-center {{ $user->profile_pic ? 'hidden' : '' }}">
                            <svg class="w-16 h-16 text-body mx-auto mb-2 group-hover:text-heading transition" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM3 20a6 6 0 0 1 12 0v1H3v-1z"/>
                            </svg>
                            <p class="text-xs font-medium text-body group-hover:text-heading transition">Upload Photo</p>
                            <p class="text-xs text-body mt-1">JPG, PNG up to 2MB</p>
                        </div>

                        {{-- The Hidden File Input (Keep name as profile_picture to match $request in controller) --}}
                        <input type="file" name="profile_picture" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>

                {{-- Profile Info Card --}}
                <div class="bg-neutral-primary-soft border border-default rounded-lg p-4">
                    <div class="mb-3">
                        <p class="text-xs font-semibold text-body uppercase tracking-wide">Member Since</p>
                        <p class="text-sm font-medium text-heading mt-1">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                    <hr class="border-default my-3">
                    <div>
                        <p class="text-xs font-semibold text-body uppercase tracking-wide">Last Updated</p>
                        <p class="text-sm font-medium text-heading mt-1">{{ $user->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>

                {{-- Quick Action Buttons --}}
                <div class="mt-4 space-y-2">
                    {{-- This button triggers the separate form below --}}
                    <button type="button"
                            onclick="confirmDelete()"
                            class="w-full text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 rounded-base px-4 py-2.5 transition">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Column: Profile Form --}}
        <div class="lg:col-span-2">
            {{-- Personal Information Section --}}
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-heading">Personal Information</h2>
                    <p class="text-sm text-body mt-1">Update your basic account details</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-heading">Username</label>
                            <input type="text" name="username" id="username" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="John" value="{{ $user->name }}" />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-heading">Email Address</label>
                        <input type="email" name="email" id="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="john.doe@example.com" value="{{ $user->email }}" />
                        <p class="text-xs text-body mt-1">Your email is used for login and notifications</p>
                    </div>
                </div>
            </div>

            {{-- Security Section --}}
            <div class="bg-white rounded-lg shadow-xs p-6 border border-gray-200 mb-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-heading">Security Settings</h2>
                    <p class="text-sm text-body mt-1">Manage your account security and password</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block mb-2 text-sm font-medium text-heading">New Password</label>
                            <input type="password" name="password" id="new_password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="••••••••" />
                        </div>

                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-heading">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="confirm_password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-2 focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" placeholder="••••••••" />
                        </div>
                    </div>

                    <div class="bg-neutral-primary-soft border border-default rounded-lg p-4">
                        <p class="text-xs font-semibold text-body uppercase tracking-wide mb-3">Password Requirements</p>
                        <ul class="space-y-2 text-xs text-body">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> At least 8 characters long</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> Contains uppercase letters (A-Z)</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-body rounded-full"></span> Contains numbers (0-9)</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 sticky bottom-0 bg-white pt-4 pb-6 border-t border-gray-200">
                <button type="button" class="flex-1 text-heading bg-neutral-primary-soft border border-default hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary rounded-base px-4 py-2.5 font-medium text-sm transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 rounded-base px-4 py-2.5 font-medium text-sm transition">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</form>
<form id="delete-account-form" action="{{ route('account.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
{{-- Validation Error Modal --}}
@if($errors->has('password'))
<div id="error-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 border border-gray-200">
        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-center text-heading">Security Error</h3>
        <p class="mt-2 text-sm text-center text-body">
            {{ $errors->first('password') }}
        </p>
        <div class="mt-6">
            <button onclick="document.getElementById('error-modal').remove()"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-base hover:bg-blue-700 transition">
                Try Again
            </button>
        </div>
    </div>
</div>
@endif
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            document.getElementById('delete-account-form').submit();
        }
    }
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('image_preview');
        const placeholder = document.getElementById('upload_placeholder');

        reader.onload = function() {
            if (reader.readyState === 2) {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

@endsection
