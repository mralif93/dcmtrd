<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tenant Details') }}
            </h2>
            <a href="{{ route('tenants.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $tenant->name }}</h3>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Property Information</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Property Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->property->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Property Address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->property->address }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('City') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->property->city }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('State/Country') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->property->state }}, {{ $tenant->property->country }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Tenant Information</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Tenant Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Contact Person') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->contact_person ?? 'Not provided' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->email ?? 'Not provided' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Phone') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->phone ?? 'Not provided' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Status') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($tenant->status) }}
                                        </span>
                                        @if($tenant->isExpired())
                                            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Expired
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">{{ __('Lease Period') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        From {{ $tenant->commencement_date->format('d M Y') }} to {{ $tenant->expiry_date->format('d M Y') }}
                                        ({{ $tenant->daysUntilExpiry() }} days remaining)
                                    </dd>
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
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenant->created_at->format('d/m/Y h:i A') }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">{{ __('Updated At') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenant->updated_at->format('d/m/Y h:i A') }}</dd>
                                    </div>
                                </dl>
                            </h4>
                        </div>
                    </div>

                    @if($tenant->leases->count() > 0)
                        <div class="mt-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Associated Leases</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lease Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Premises</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rental Amount</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($tenant->leases as $lease)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $lease->lease_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lease->demised_premises }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $lease->start_date->format('d M Y') }} - {{ $lease->end_date->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ number_format($lease->rental_amount, 2) }} ({{ $lease->rental_frequency }})
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $lease->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ ucfirst($lease->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                        <div class="flex justify-end gap-x-4">
                            <a href="{{ route('tenants.index') }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('tenants.edit', $tenant) }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Property
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>