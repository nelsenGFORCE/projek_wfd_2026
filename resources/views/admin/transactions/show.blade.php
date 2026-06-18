@extends('layouts.admin')

@section('title', 'Transaction Detail')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-petra hover:text-petra-dark transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Transactions
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Transaction Info</h2>
                    @if($transaction->payment_status === 'success')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">Paid</span>
                    @elseif($transaction->payment_status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Failed</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Booking Code</p>
                        <p class="font-mono font-bold text-petra text-lg">{{ $transaction->midtrans_booking_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Price</p>
                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Order Date</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Movie</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->schedule->movie->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Studio</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->schedule->studio->studio_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Show Time</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->schedule->show_date->format('d M Y') }} {{ \Carbon\Carbon::parse($transaction->schedule->start_time)->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Booked Seats</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($transaction->transactionDetails as $detail)
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-lg text-sm font-bold {{ $transaction->payment_status === 'success' ? 'bg-red-500 text-white' : ($transaction->payment_status === 'pending' ? 'bg-yellow-400 text-yellow-900' : 'bg-gray-200 text-gray-500') }}">
                            {{ $detail->seat->seat_number }}
                        </span>
                    @endforeach
                </div>
                <div class="mt-4 p-4 rounded-lg {{ $transaction->payment_status === 'success' ? 'bg-red-50 border border-red-200' : ($transaction->payment_status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50 border border-gray-200') }}">
                    <p class="text-sm {{ $transaction->payment_status === 'success' ? 'text-red-700' : ($transaction->payment_status === 'pending' ? 'text-yellow-700' : 'text-gray-600') }}">
                        @if($transaction->payment_status === 'success')
                            These seats are <strong>occupied</strong> and cannot be booked by other customers.
                        @elseif($transaction->payment_status === 'pending')
                            These seats are <strong>reserved</strong> and currently unavailable for booking.
                        @else
                            These seats are <strong>released</strong> and available for booking again.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Customer Info</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-petra rounded-full flex items-center justify-center text-white text-lg font-bold">
                        {{ strtoupper($transaction->user->name[0]) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $transaction->user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Ticket Price</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($transaction->schedule->ticket_price, 0, ',', '.') }}/seat</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Number of Seats</span>
                        <span class="font-semibold text-gray-800">{{ $transaction->transactionDetails->count() }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-bold text-lg text-petra">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection