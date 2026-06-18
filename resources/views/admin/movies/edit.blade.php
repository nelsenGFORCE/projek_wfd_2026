@extends('layouts.admin')

@section('title', 'Edit Movie')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.movies.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Movie</h1>
    </div>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @method('PUT')

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

        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('title') border-red-500 @enderror" required>
            @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="synopsis" class="block text-sm font-semibold text-gray-700 mb-2">Synopsis</label>
            <textarea name="synopsis" id="synopsis" rows="4" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('synopsis') border-red-500 @enderror">{{ old('synopsis', $movie->synopsis) }}</textarea>
            @error('synopsis') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="duration" class="block text-sm font-semibold text-gray-700 mb-2">Duration (minutes) <span class="text-red-500">*</span></label>
                <input type="number" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}" min="1" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('duration') border-red-500 @enderror" required>
                @error('duration') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="genre" class="block text-sm font-semibold text-gray-700 mb-2">Genre <span class="text-red-500">*</span></label>
                <input type="text" name="genre" id="genre" value="{{ old('genre', $movie->genre) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('genre') border-red-500 @enderror" required>
                @error('genre') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="poster" class="block text-sm font-semibold text-gray-700 mb-2">Poster Image</label>
            @if($movie->poster)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-32 h-44 object-cover rounded shadow-sm">
                </div>
            @endif
            <input type="file" name="poster" id="poster" accept="image/*" class="w-full px-4 py-2.5 border rounded-lg @error('poster') border-red-500 @enderror">
            @error('poster') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" id="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('status') border-red-500 @enderror" required>
                <option value="now_showing" {{ old('status', $movie->status) === 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                <option value="coming_soon" {{ old('status', $movie->status) === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
            </select>
            @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.movies.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium shadow-sm">Update Movie</button>
        </div>
    </form>
</div>
@endsection
