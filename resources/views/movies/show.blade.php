@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3 lg:w-1/4 flex-shrink-0">
                @if($movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 md:h-full object-cover">
                @else
                    <div class="w-full h-64 md:h-96 bg-gradient-to-br from-petra to-petra-dark flex items-center justify-center">
                        <svg class="w-24 h-24 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="flex-1 p-6 md:p-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $movie->title }}</h1>

                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="bg-petra text-white text-sm font-semibold px-3 py-1 rounded-full">{{ $movie->genre }}</span>
                    <span class="flex items-center text-gray-600 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $movie->duration }} min
                    </span>
                </div>

                <div class="prose prose-gray max-w-none">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Synopsis</h3>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $movie->synopsis ?? 'No synopsis available.' }}</p>
                </div>
            </div>
        </div>
    </div>

    @guest
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 md:p-6 rounded-r-lg mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-yellow-800">Login Required</h3>
                    <p class="text-yellow-700 text-sm mt-1">You need to be logged in to purchase tickets.</p>
                    <div class="mt-3 flex gap-3">
                        <a href="{{ route('login') }}" class="bg-petra hover:bg-petra-dark text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">Login</a>
                        <a href="{{ route('register') }}" class="border border-petra text-petra hover:bg-petra hover:text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">Register</a>
                    </div>
                </div>
            </div>
        </div>
    @endguest

    @if($schedules->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Showtimes</h2>

            <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 pb-4" x-data="{ activeDate: '{{ $schedules->keys()->first() }}' }">
                @foreach($schedules->keys() as $date)
                    <button
                        @click="activeDate = '{{ $date }}'"
                        :class="activeDate === '{{ $date }}' ? 'bg-petra text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm transition-colors"
                    >
                        {{ \Carbon\Carbon::parse($date)->format('D, d M') }}
                    </button>
                @endforeach
            </div>

            @foreach($schedules as $date => $group)
                <div x-show="activeDate === '{{ $date }}'" x-transition>
                    <div class="space-y-4">
                        @foreach($group as $schedule)
                            <div class="border border-gray-200 rounded-xl p-4 md:p-5 hover:border-petra-light transition-colors">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="bg-petra-light bg-opacity-10 text-petra-dark font-bold text-sm px-3 py-1 rounded-lg">
                                                {{ $schedule->studio_name ?? $schedule->studio->studio_name }}
                                            </span>
                                            <span class="text-gray-700 font-semibold text-lg">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0-5.856a3 3 0 106-5.856 3 3 0 00-6 5.856zm6 0a3 3 0 106-5.856 3 3 0 00-6 5.856z"/>
                                                </svg>
                                                {{ $schedule->available_seats ?? 0 }} seats available
                                            </span>
                                            <span class="font-bold text-petra">Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    @auth
                                        <a href="{{ url('/booking/' . $schedule->id . '/seats') }}" class="bg-petra hover:bg-petra-dark text-white font-semibold px-6 py-2.5 rounded-lg transition-colors text-center text-sm whitespace-nowrap">
                                            Select Seats
                                        </a>
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}" class="bg-gray-300 text-gray-500 font-semibold px-6 py-2.5 rounded-lg text-center text-sm whitespace-nowrap cursor-default">
                                            Select Seats
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No Showtimes Available</h3>
            <p class="text-gray-400">There are no scheduled showtimes for this movie yet.</p>
        </div>
    @endif
</div>
@endsection