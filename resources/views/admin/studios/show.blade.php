@extends('layouts.admin')

@section('title', 'Studio Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.studios.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">{{ $studio->studio_name }}</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Studio Name</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $studio->studio_name }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Capacity</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $studio->capacity }} seats</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Seats ({{ $studio->seats->count() }})</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($studio->seats->sortBy('seat_number') as $seat)
                    <span class="bg-petra bg-opacity-10 text-petra-dark text-xs font-semibold px-2.5 py-1 rounded">{{ $seat->seat_number }}</span>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.studios.edit', $studio->id) }}" class="inline-flex items-center px-4 py-2 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" onsubmit="return confirm('Delete this studio?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium text-sm">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
