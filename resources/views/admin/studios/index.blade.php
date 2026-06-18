@extends('layouts.admin')

@section('title', 'Studios')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Studios</h1>
        <a href="{{ route('admin.studios.create') }}" class="inline-flex items-center px-4 py-2 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Studio
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Studio Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Capacity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Seats Created</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($studios as $studio)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $studio->studio_name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $studio->capacity }} seats</td>
                        <td class="px-6 py-4 text-gray-600">{{ $studio->seats->count() }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.studios.show', $studio->id) }}" class="inline-flex items-center p-2 text-petra hover:bg-petra hover:text-white rounded-lg transition-colors" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.studios.edit', $studio->id) }}" class="inline-flex items-center p-2 text-petra hover:bg-petra hover:text-white rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" onsubmit="return confirm('Delete this studio and all its seats?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center p-2 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-lg font-medium">No studios found</p>
                            <a href="{{ route('admin.studios.create') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors">Add Studio</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($studios->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $studios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
