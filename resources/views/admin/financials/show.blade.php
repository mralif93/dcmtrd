<!-- resources/views/financials/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Record Details') }}
            </h2>
            <div>
                <a href="{{ route('financials.edit', $financial->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow transition ease-in-out duration-150 mr-2">
                    Edit
                </a>
                <a href="{{ route('financials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Basic Information</h3>
                        </div>

                        <!-- Portfolio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Portfolio</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->portfolio->portfolio_name }}</div>
                        </div>

                        <!-- Bank -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Bank</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->bank->name }}</div>
                        </div>

                        <!-- Financial Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Financial Type</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->financialType->name }}</div>
                        </div>

                        <!-- Purpose -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Purpose</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->purpose }}</div>
                        </div>

                        <!-- Tenure -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tenure</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->tenure }}</div>
                        </div>

                        <!-- Installment Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Installment Date</label>
                            <div class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($financial->installment_date)->format('d M Y') }}</div>
                        </div>

                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Financial Details</h3>
                        </div>

                        <!-- Profit Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Profit Type</label>
                            <div class="mt-1 text-sm text-gray-900">{{ ucfirst($financial->profit_type) }}</div>
                        </div>

                        <!-- Profit Rate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Profit Rate</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->profit_rate }}%</div>
                        </div>

                        <!-- Process Fee -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Process Fee</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->process_fee, 2) }}</div>
                        </div>

                        <!-- Total Facility Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Total Facility Amount</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->total_facility_amount, 2) }}</div>
                        </div>

                        <!-- Utilization Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Utilization Amount</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->utilization_amount, 2) }}</div>
                        </div>

                        <!-- Outstanding Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Outstanding Amount</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->outstanding_amount, 2) }}</div>
                        </div>

                        <!-- Interest Monthly -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Interest Monthly</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->interest_monthly, 2) }}</div>
                        </div>

                        <!-- Security Value Monthly -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Security Value Monthly</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($financial->security_value_monthly, 2) }}</div>
                        </div>

                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Contact Information</h3>
                        </div>

                        <!-- Facilities Agent -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Facilities Agent</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->facilities_agent }}</div>
                        </div>

                        <!-- Agent Contact -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Agent Contact</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->agent_contact ?: 'N/A' }}</div>
                        </div>

                        <!-- Valuer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Valuer</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->valuer }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $financial->status === 'active' ? 'bg-green-100 text-green-800' : ($financial->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($financial->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Record Information</h3>
                        </div>

                        <!-- Created At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created At</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $financial->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-4 mt-6">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('financials.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('financials.edit', $financial) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Edit Financial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>