@extends('layouts.admin')

@section('title', 'Schedule Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.schedules.index') }}" class="mr-4 text-gray-500 hover:text-petra transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Schedule Details</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Movie</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $schedule->movie->title }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Studio</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $schedule->studio->studio_name }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Show Date</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ $schedule->show_date->format('l, d M Y') }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Start Time</label>
                <p class="text-lg font-bold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</p>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Ticket Price</label>
                <p class="text-lg font-bold text-petra mt-1">Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="inline-flex items-center px-4 py-2 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Delete this schedule?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium text-sm">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
