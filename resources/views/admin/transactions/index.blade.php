@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex gap-2">
            <select name="status" class="px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra text-sm">
                <option value="">All Status</option>
                <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search booking code or name..." class="px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-petra focus:border-petra text-sm">
            <button type="submit" class="px-4 py-2.5 bg-petra text-white rounded-lg hover:bg-petra-dark transition-colors text-sm font-medium">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Booking Code</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Movie</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-sm font-bold text-petra">{{ $transaction->midtrans_booking_code }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $transaction->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $transaction->schedule->movie->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $transaction->schedule->studio->studio_name }}<br>
                            {{ $transaction->schedule->show_date->format('d M Y') }} {{ \Carbon\Carbon::parse($transaction->schedule->start_time)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($transaction->payment_status === 'success')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Paid</span>
                            @elseif($transaction->payment_status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Failed</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <p class="text-lg font-medium">No transactions found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($transactions, 'links') && $transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
