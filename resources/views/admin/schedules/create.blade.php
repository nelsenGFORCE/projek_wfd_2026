@extends('layouts.admin')

@section('title', 'Add Schedule')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.schedules.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Add Schedule</h1>
    </div>

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
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
            <label for="movie_id" class="block text-sm font-semibold text-gray-700 mb-2">Movie <span class="text-red-500">*</span></label>
            <select name="movie_id" id="movie_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('movie_id') border-red-500 @enderror" required>
                <option value="">Select a movie</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                @endforeach
            </select>
            @error('movie_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="studio_id" class="block text-sm font-semibold text-gray-700 mb-2">Studio <span class="text-red-500">*</span></label>
            <select name="studio_id" id="studio_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('studio_id') border-red-500 @enderror" required>
                <option value="">Select a studio</option>
                @foreach($studios as $studio)
                    <option value="{{ $studio->id }}" {{ old('studio_id') == $studio->id ? 'selected' : '' }}>{{ $studio->studio_name }} ({{ $studio->capacity }} seats)</option>
                @endforeach
            </select>
            @error('studio_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="show_date" class="block text-sm font-semibold text-gray-700 mb-2">Show Date <span class="text-red-500">*</span></label>
                <input type="date" name="show_date" id="show_date" value="{{ old('show_date') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('show_date') border-red-500 @enderror" required>
                @error('show_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">Start Time <span class="text-red-500">*</span></label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('start_time') border-red-500 @enderror" required>
                @error('start_time') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="ticket_price" class="block text-sm font-semibold text-gray-700 mb-2">Ticket Price (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="ticket_price" id="ticket_price" value="{{ old('ticket_price') }}" min="0" step="1000" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra transition-colors @error('ticket_price') border-red-500 @enderror" placeholder="e.g. 50000" required>
            @error('ticket_price') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.schedules.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium shadow-sm">Create Schedule</button>
        </div>
    </form>
</div>
@endsection
