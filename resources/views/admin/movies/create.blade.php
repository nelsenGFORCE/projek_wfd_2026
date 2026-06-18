@extends('layouts.admin')

@section('title', 'Add Movie')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.movies.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Add Movie</h1>
    </div>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <p class="font-medium">Please fix the following errors:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('title') border-red-500 @enderror" placeholder="Enter movie title" required>
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Synopsis -->
        <div>
            <label for="synopsis" class="block text-sm font-semibold text-gray-700 mb-2">Synopsis</label>
            <textarea name="synopsis" id="synopsis" rows="4" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('synopsis') border-red-500 @enderror" placeholder="Enter movie synopsis">{{ old('synopsis') }}</textarea>
            @error('synopsis')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Duration & Genre -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Duration (minutes) <span class="text-red-500">*</span></label>
                <input type="number" name="duration" id="duration" value="{{ old('duration') }}" min="1" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('duration') border-red-500 @enderror" placeholder="e.g. 120" required>
                @error('duration')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="genre" class="block text-sm font-semibold text-gray-700 mb-2">Genre <span class="text-red-500">*</span></label>
                <input type="text" name="genre" id="genre" value="{{ old('genre') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('genre') border-red-500 @enderror" placeholder="e.g. Action, Drama" required>
                @error('genre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Poster -->
        <div>
            <label for="poster" class="block text-sm font-semibold text-gray-700 mb-2">Poster Image</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-petra transition-colors" id="poster-drop">
                <div class="space-y-2 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="poster" class="relative cursor-pointer bg-white rounded-md font-medium text-petra hover:text-petra-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-petra">
                            <span>Upload a file</span>
                            <input type="file" name="poster" id="poster" accept="image/*" class="sr-only" onchange="previewPoster(this)">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                </div>
            </div>
            <div id="poster-preview" class="mt-4 hidden">
                <img id="poster-preview-img" src="" alt="Preview" class="max-w-xs max-h-64 rounded-lg shadow-sm">
            </div>
            @error('poster')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" id="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('status') border-red-500 @enderror" required>
                <option value="now_showing" {{ old('status') == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                <option value="coming_soon" {{ old('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.movies.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors duration-200 font-medium shadow-sm">
                Create Movie
            </button>
        </div>
    </form>
</div>

<script>
    function previewPoster(input) {
        const preview = document.getElementById('poster-preview');
        const previewImg = document.getElementById('poster-preview-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection