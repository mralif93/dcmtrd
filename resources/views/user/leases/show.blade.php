<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lease Details') }}
            </h2>
            <a href="{{ route('leases-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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

            <div class="bg-white shadow rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ $lease->lease_name }}</h3>
                    <div>
                        <a href="{{ route('leases-info.edit', $lease->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 mr-2">
                            Edit
                        </a>
                        <form action="{{ route('leases-info.destroy', $lease->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this lease?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Lease Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lease Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->lease_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Demised Premises</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->demised_premises }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Permitted Use</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->permitted_use }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ date('M d, Y', strtotime($lease->start_date)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ date('M d, Y', strtotime($lease->end_date)) }}
                                @if($lease->isExpiringSoon() && $lease->status === 'active')
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Expiring Soon
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Term</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->term_years }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Option to Renew</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->option_to_renew ? 'Yes' : 'No' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $lease->status === 'active' ? 'bg-green-100 text-green-800' : 
                                               ($lease->status === 'expired' ? 'bg-red-100 text-red-800' : 
                                               ($lease->status === 'terminated' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($lease->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ date('M d, Y H:i', strtotime($lease->created_at)) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Financial Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Rental Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($lease->rental_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Rental Frequency</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($lease->rental_frequency) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Contract Value</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($lease->getTotalContractValue(), 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Remaining Term</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($lease->isExpired())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Expired
                                    </span>
                                @else
                                    {{ $lease->getRemainingTerm() }} days
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Tenant & Property Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tenant Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('tenants.show', $lease->tenant->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $lease->tenant->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->contact_person ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $lease->tenant->phone ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Property</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $lease->tenant->property->name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Property Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $lease->tenant->property->address }},
                                {{ $lease->tenant->property->city }},
                                {{ $lease->tenant->property->state }},
                                {{ $lease->tenant->property->country }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Status Update Form -->
                <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Update Lease Status</h4>
                    <form action="{{ route('leases-info.update-status', $lease->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center space-x-4">
                            <div class="flex-grow">
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" {{ $lease->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $lease->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="terminated" {{ $lease->status === 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    <option value="expired" {{ $lease->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>