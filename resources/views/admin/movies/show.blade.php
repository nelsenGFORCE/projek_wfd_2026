@extends('layouts.admin')

@section('title', 'Movie Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.movies.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">{{ $movie->title }}</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="flex flex-col md:flex-row">
            @if($movie->poster)
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 md:h-full object-cover">
                </div>
            @endif
            <div class="flex-1 p-6 md:p-8">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Title</label>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $movie->title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Synopsis</label>
                        <p class="text-gray-700 mt-1 whitespace-pre-line">{{ $movie->synopsis }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Genre</label>
                            <p class="text-gray-800 mt-1">{{ $movie->genre }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Duration</label>
                            <p class="text-gray-800 mt-1">{{ $movie->duration }} min</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Status</label>
                            @if($movie->status === 'now_showing')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 mt-1">Now Showing</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mt-1">Coming Soon</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="inline-flex items-center px-4 py-2 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
