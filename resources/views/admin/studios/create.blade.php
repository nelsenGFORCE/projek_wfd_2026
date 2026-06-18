@extends('layouts.admin')

@section('title', 'Add Studio')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.studios.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Add Studio</h1>
    </div>

    <form action="{{ route('admin.studios.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
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

        <div>
            <label for="studio_name" class="block text-sm font-semibold text-gray-700 mb-2">Studio Name <span class="text-red-500">*</span></label>
            <input type="text" name="studio_name" id="studio_name" value="{{ old('studio_name') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('studio_name') border-red-500 @enderror" placeholder="e.g. Studio 1" required>
            @error('studio_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">Capacity <span class="text-red-500">*</span></label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('capacity') border-red-500 @enderror" placeholder="e.g. 80" required>
            <p class="mt-1 text-sm text-gray-500">Seats will be automatically generated (rows A-J).</p>
            @error('capacity') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.studios.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium shadow-sm">Create Studio</button>
        </div>
    </form>
</div>
@endsection
