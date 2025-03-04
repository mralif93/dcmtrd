<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lease Details') }}
            </h2>
            <a href="{{ route('checklists.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $lease->lease_name }}</h3>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Tenant & Property Information</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Tenant Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Tenant Contact Person') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->contact_person ?? 'Not provided' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Property') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->property->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Property Address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->property->address }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Lease Information</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Lease Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->lease_name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Status') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $lease->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($lease->status) }}
                                        </span>
                                        @if($lease->isExpired())
                                            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Expired
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Demised Premises') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->demised_premises }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Permitted Use') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->permitted_use }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Rental Amount') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($lease->rental_amount, 2) }} ({{ ucfirst($lease->rental_frequency) }})</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Term Years') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->term_years }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Lease Period') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        From {{ $lease->start_date->format('d M Y') }} to {{ $lease->end_date->format('d M Y') }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Option to Renew') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->option_to_renew ? 'Yes' : 'No' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Created At') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Updated At') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">System Information</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Created At') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->created_at->format('d/m/Y h:i A') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Updated At') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $lease->updated_at->format('d/m/Y h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    
                    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                        <div class="flex justify-end gap-x-4">
                            <a href="{{ route('leases.index') }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('leases.edit', $lease) }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Lease
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>