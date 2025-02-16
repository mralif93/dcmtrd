<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Call Schedule Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Detailed information for {{ $schedule->redemption->bond->isin_code }}</p>
            </div>

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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Core Information Section -->
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Core Call Information</h3>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Associated Bond</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $schedule->redemption->bond->isin_code }} - 
                                    {{ $schedule->redemption->bond->stock_code }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Redemption Configuration</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $schedule->redemption->allow_partial_call ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $schedule->redemption->allow_partial_call ? 'Partial Call Allowed' : 'Partial Call Not Allowed' }}
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Call Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    RM{{ number_format($schedule->call_price, 2) }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Redemption Option</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        {{ $schedule->redemption->redeem_nearest_denomination ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $schedule->redemption->redeem_nearest_denomination ? 'Nearest Denomination' : 'Standard Redemption' }}
                                    </span>
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Schedule Dates Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule Period</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $schedule->start_date->format('d/m/Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $schedule->end_date->format('d/m/Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Call Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $schedule->redemption->last_call_date->format('d/m/Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $schedule->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $schedule->updated_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('call-schedules.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('call-schedules.edit', $schedule) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Call Schedule
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>