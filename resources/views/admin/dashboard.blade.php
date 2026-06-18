@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Movies -->
        <div class="bg-gradient-to-br from-petra to-petra-dark rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide opacity-80">Total Movies</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalMovies ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.movies.index') }}" class="text-white hover:underline opacity-80 hover:opacity-100 transition-opacity">View all movies &rarr;</a>
            </div>
        </div>

        <!-- Schedules Today -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide opacity-80">Schedules Today</p>
                    <p class="text-3xl font-bold mt-2">{{ $schedulesToday ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.schedules.index') }}" class="text-white hover:underline opacity-80 hover:opacity-100 transition-opacity">View schedules &rarr;</a>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide opacity-80">Total Transactions</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalTransactions ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.transactions.index') }}" class="text-white hover:underline opacity-80 hover:opacity-100 transition-opacity">View transactions &rarr;</a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide opacity-80">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.403 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.403-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.transactions.index') }}" class="text-white hover:underline opacity-80 hover:opacity-100 transition-opacity">View details &rarr;</a>
            </div>
        </div>

        <!-- Pending Transactions -->
        @if(($pendingTransactions ?? 0) > 0)
        <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200 ring-4 ring-red-300 ring-opacity-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-wide opacity-80">Pending Orders</p>
                    <p class="text-3xl font-bold mt-2">{{ $pendingTransactions ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="text-white hover:underline opacity-80 hover:opacity-100 transition-opacity">View pending orders &rarr;</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.movies.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-petra hover:text-white text-gray-600 transition-colors duration-200 group">
                <svg class="w-8 h-8 mb-2 text-petra group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-sm font-medium">Add Movie</span>
            </a>
            <a href="{{ route('admin.studios.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-petra hover:text-white text-gray-600 transition-colors duration-200 group">
                <svg class="w-8 h-8 mb-2 text-petra group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-sm font-medium">Add Studio</span>
            </a>
            <a href="{{ route('admin.schedules.create') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-petra hover:text-white text-gray-600 transition-colors duration-200 group">
                <svg class="w-8 h-8 mb-2 text-petra group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-sm font-medium">Add Schedule</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-petra hover:text-white text-gray-600 transition-colors duration-200 group">
                <svg class="w-8 h-8 mb-2 text-petra group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-sm font-medium">View Reports</span>
            </a>
        </div>
    </div>
</div>
@endsection