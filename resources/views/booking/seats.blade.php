@extends('layouts.app')

@section('title', 'Select Seats')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ url('/movies/' . $schedule->movie->id) }}" class="inline-flex items-center text-petra hover:text-petra-dark transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Movie
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $schedule->movie->title }}</h1>
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                {{ $schedule->studio->studio_name }}
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $schedule->show_date->format('l, d M Y') }}
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
            </span>
        </div>
        <div class="text-lg font-bold text-petra">Rp {{ number_format($schedule->ticket_price, 0, ',', '.') }}/seat</div>
    </div>

    <form action="{{ route('booking.checkout', $schedule->id) }}" method="POST" x-data="{ selectedSeats: [] }">
        @csrf
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Select Your Seats</h2>

            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center"><div class="w-8 h-8 bg-gray-200 border-2 border-gray-300 rounded mr-2"></div> Available</div>
                    <div class="flex items-center"><div class="w-8 h-8 bg-petra border-2 border-petra-dark rounded mr-2"></div> Selected</div>
                    <div class="flex items-center"><div class="w-8 h-8 bg-red-400 border-2 border-red-500 rounded mr-2"></div> Booked</div>
                </div>
            </div>

            <div class="bg-gray-100 text-center py-3 rounded-t-xl mb-4">
                <span class="text-gray-600 font-semibold text-sm uppercase">Screen</span>
            </div>

            <div class="grid grid-cols-10 gap-2 mb-6">
                @foreach($seats as $seat)
                    <button
                        type="button"
                        @if($seat['is_booked']) disabled @endif
                        @click="if (!{{ $seat['is_booked'] ? 'true' : 'false' }}) { 
                            const id = {{ $seat['id'] }}; 
                            const idx = selectedSeats.indexOf(id); 
                            if (idx > -1) { selectedSeats.splice(idx, 1) } else { selectedSeats.push(id) } 
                        }"
                        :class="{
                            'bg-gray-200 border-gray-300 hover:bg-gray-300': !{{ $seat['is_booked'] ? 'true' : 'false' }} && !selectedSeats.includes({{ $seat['id'] }}),
                            'bg-petra border-petra-dark text-white': selectedSeats.includes({{ $seat['id'] }}),
                            'bg-red-400 border-red-500 text-white cursor-not-allowed': {{ $seat['is_booked'] ? 'true' : 'false' }}
                        }"
                        class="aspect-square rounded border-2 text-xs font-semibold transition-colors flex items-center justify-center"
                    >
                        {{ $seat['seat_number'] }}
                    </button>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <p class="text-sm text-gray-600 mb-2" x-text="selectedSeats.length > 0 ? 'Selected: ' + selectedSeats.length + ' seat(s)' : 'No seats selected'"></p>
                <p class="text-lg font-bold text-gray-800" x-show="selectedSeats.length > 0" x-text="'Total: Rp ' + new Intl.NumberFormat('id-ID').format({{ $schedule->ticket_price }} * selectedSeats.length)"></p>
            </div>

            @foreach($seats as $seat)
                <template x-if="selectedSeats.includes({{ $seat['id'] }})">
                    <input type="hidden" name="seat_ids[]" :value="{{ $seat['id'] }}" x-ref="seat_{{ $seat['id'] }}">
                </template>
            @endforeach

            <div class="mt-6">
                <button type="submit" x-bind:disabled="selectedSeats.length === 0"
                    :class="selectedSeats.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-petra hover:bg-petra-dark'"
                    class="w-full text-white font-semibold py-3 rounded-lg transition-colors">
                    Proceed to Payment
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
