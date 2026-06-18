@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="relative bg-gradient-to-br from-petra-dark via-petra to-petra-light overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-60 h-60 bg-white rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 relative z-10">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 tracking-tight">
                Bioskop Petra
            </h1>
            <p class="text-lg md:text-2xl text-petra-light font-light mb-8 max-w-2xl mx-auto">
                Experience cinema like never before. Premium screens, premium comfort, premium memories.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('movies.index') }}" class="inline-block bg-white text-petra-dark font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors text-lg shadow-lg">
                    Browse Movies
                </a>
                @auth
                    <a href="{{ route('transactions.index') }}" class="inline-block border-2 border-white text-white font-bold px-8 py-3 rounded-lg hover:bg-white hover:text-petra-dark transition-colors text-lg">
                        My Tickets
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form method="GET" action="{{ route('movies.index') }}" class="max-w-xl mx-auto">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search movies by title..." class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-petra focus:outline-none transition-colors text-gray-700 shadow-sm">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </form>
</section>

@if($nowShowing->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            <span class="text-petra">Now Showing</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($nowShowing as $movie)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="relative overflow-hidden">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-petra to-petra-dark flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="bg-petra text-white text-xs font-bold px-2 py-1 rounded-full shadow">{{ $movie->duration }} min</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-1">{{ $movie->title }}</h3>
                    <div class="flex items-center flex-wrap gap-2 mb-3">
                        <span class="bg-petra-light bg-opacity-10 text-petra-dark text-xs font-semibold px-2 py-1 rounded">{{ $movie->genre }}</span>
                    </div>
                    @if($movie->schedules && $movie->schedules->count() > 0)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Rp {{ number_format($movie->schedules->first()->ticket_price, 0, ',', '.') }}</span>
                            <a href="{{ route('movies.show', $movie->id) }}" class="bg-petra hover:bg-petra-dark text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">
                                Buy Ticket
                            </a>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400">No schedules</span>
                            <a href="{{ route('movies.show', $movie->id) }}" class="bg-gray-300 text-gray-500 font-semibold px-4 py-2 rounded-lg text-sm cursor-default">
                                Buy Ticket
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

@if($comingSoon->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            <span class="text-petra-light">Coming Soon</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($comingSoon as $movie)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group opacity-90">
                <div class="relative overflow-hidden">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300 grayscale">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <span class="bg-yellow-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">Coming Soon</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-600 mb-2 line-clamp-1">{{ $movie->title }}</h3>
                    <div class="flex items-center flex-wrap gap-2 mb-3">
                        <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-1 rounded">{{ $movie->genre }}</span>
                    </div>
                    <p class="text-sm text-gray-400">Not yet available for booking</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

@if($nowShowing->count() === 0 && $comingSoon->count() === 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h18M3 4h18v16H3z"/>
    </svg>
    <h3 class="text-xl font-semibold text-gray-500 mb-2">No Movies Available</h3>
    <p class="text-gray-400">Check back later for upcoming movies!</p>
</section>
@endif
@endsection