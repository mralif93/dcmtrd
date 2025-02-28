<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment Schedules List') }}
            </h2>
            <a href="{{ route('payment-schedules.create') }}" class="bg-blue-500 hover:bg-blue-700 rounded-lg text-white font-bold py-2 px-4">
                Create Payment Schedule
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <!-- Search and Create Header -->
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                    <form method="GET" action="{{ route('payment-schedules.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search by coupon rate, dates, or bond..." 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('payment-schedules.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bond</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Period</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Ex-Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Coupon Rate</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Adjustment</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($paymentSchedules as $schedule)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-indigo-600">{{ $schedule->bond->bond_sukuk_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $schedule->bond->sub_name }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $schedule->start_date->format('d/m/Y') }} - 
                                            {{ $schedule->end_date->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Payment: {{ $schedule->payment_date->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $schedule->ex_date->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ number_format($schedule->coupon_rate, 2) }}%
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        @if($schedule->adjustment_date)
                                        <div class="text-sm text-gray-500">
                                            {{ $schedule->adjustment_date->format('d/m/Y') }}
                                        </div>
                                        @else
                                        <span class="text-xs text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('payment-schedules.show', $schedule) }}" 
                                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('payment-schedules.edit', $schedule) }}" 
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('payment-schedules.destroy', $schedule) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors"
                                                    onclick="return confirm('Delete this payment schedule?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No payment schedules found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($paymentSchedules->hasPages())
                    <div class="mt-6">
                        {{ $paymentSchedules->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>