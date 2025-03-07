<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenant Approval Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $tenantApproval->tenant->name ?? 'Unknown Tenant' }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tenantApproval->approval_type == 'new' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($tenantApproval->approval_type) }} Approval
                                </span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('tenant-approvals-info.edit', $tenantApproval->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('tenant-approvals-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <!-- Current Status -->
                        <div class="col-span-2 bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Current Status</h4>
                            <p class="text-sm text-gray-700 font-medium">{{ $tenantApproval->status_label }}</p>
                            
                            <div class="mt-2 relative pt-1">
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                    @if ($tenantApproval->ld_verified)
                                        <div style="width:100%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                                    @elseif ($tenantApproval->od_approved)
                                        <div style="width:66%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-yellow-500"></div>
                                    @elseif ($tenantApproval->submitted_to_ld_date)
                                        <div style="width:33%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                    @else
                                        <div style="width:5%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gray-400"></div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action buttons based on status -->
                            <div class="mt-4 flex space-x-2">
                                @if (!$tenantApproval->submitted_to_ld_date)
                                    <form action="{{ route('tenant-approvals.submit-to-ld', $tenantApproval->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            {{ __('Submit to Legal Department') }}
                                        </button>
                                    </form>
                                @endif
                                
                                @if (!$tenantApproval->od_approved)
                                    <form action="{{ route('tenant-approvals.approve-by-od', $tenantApproval->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                                            {{ __('Approve by OD') }}
                                        </button>
                                    </form>
                                @endif
                                
                                @if (!$tenantApproval->ld_verified && $tenantApproval->od_approved)
                                    <form action="{{ route('tenant-approvals.verify-by-ld', $tenantApproval->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            {{ __('Verify by LD') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Tenant Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Tenant Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tenant Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->tenant->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Contact Person</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->tenant->contact_person ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->tenant->email ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->tenant->phone ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Property</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->tenant->property->name ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Approval Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Approval Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Approval Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($tenantApproval->approval_type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">OD Approved</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($tenantApproval->od_approved)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">OD Approval Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $tenantApproval->od_approval_date ? $tenantApproval->od_approval_date->format('Y-m-d') : 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">LD Verified</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($tenantApproval->ld_verified)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">LD Verification Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $tenantApproval->ld_verification_date ? $tenantApproval->ld_verification_date->format('Y-m-d') : 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Response Time Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Response Time Information</h4>
                            <dl class="grid grid-cols-1 gap-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Submitted to LD Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $tenantApproval->submitted_to_ld_date ? $tenantApproval->submitted_to_ld_date->format('Y-m-d') : 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">LD Response Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $tenantApproval->ld_response_date ? $tenantApproval->ld_response_date->format('Y-m-d') : 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Response Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if ($tenantApproval->response_time !== null)
                                            {{ $tenantApproval->response_time }} days
                                        @else
                                            N/A
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Lease Information -->
                        <div class="col-span-1">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Lease Information</h4>
                            @if ($tenantApproval->lease)
                                <dl class="grid grid-cols-1 gap-y-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Lease Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->lease->lease_name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Demised Premises</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->lease->demised_premises }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->lease->start_date->format('Y-m-d') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">End Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $tenantApproval->lease->end_date->format('Y-m-d') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Rental Amount</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($tenantApproval->lease->rental_amount, 2) }}</dd>
                                    </div>
                                </dl>
                            @else
                                <p class="text-sm text-gray-500">No lease information available</p>
                            @endif
                        </div>

                        <!-- Notes -->
                        <div class="col-span-2">
                            <h4 class="text-base font-medium text-gray-900 mb-2">Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $tenantApproval->notes ?? 'No notes available' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <form action="{{ route('tenant-approvals-info.destroy', $tenantApproval->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tenant approval?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>