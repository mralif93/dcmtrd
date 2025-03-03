<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lease Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $lease->lease_name }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.leases.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Back to List') }}
                            </a>
                            <a href="{{ route('admin.leases.edit', $lease) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Edit') }}
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg mb-6">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Tenant & Property Information</h4>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
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

                    <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Lease Information</h4>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
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

                    <div class="mt-6">
                        <form action="{{ route('admin.leases.destroy', $lease) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this lease? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>