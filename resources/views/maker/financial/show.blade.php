<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Record Details') }}
        </h2>
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header Section -->
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Financial Record: {{ $financial->portfolio->portfolio_name }}</h3>
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($financial->status)) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-blue-100 text-blue-800',
                                        'withdrawn' => 'bg-purple-100 text-purple-800',
                                        'in progress' => 'bg-indigo-100 text-indigo-800',
                                        'on hold' => 'bg-orange-100 text-orange-800',
                                        'reviewing' => 'bg-teal-100 text-teal-800',
                                        'approved' => 'bg-emerald-100 text-emerald-800',
                                        'expired' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($financial->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Basic Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Basic Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Portfolio</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{ route('portfolios-info.show', $financial->portfolio->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $financial->portfolio->portfolio_name }}
                                </a>
                            </dd>
                        </div>
                        @if($financial->prepared_by)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->prepared_by }}</dd>
                        </div>
                        @endif
                        @if($financial->verified_by)
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->verified_by }}</dd>
                        </div>
                        @endif
                        @if($financial->approval_datetime)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($financial->approval_datetime)->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Portfolio Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->portfolio->portfolioType->name ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Bank</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->bank->name }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Financial Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->financialType->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Batch No</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->batch_no }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->purpose }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tenure</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->tenure }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Installment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->installment_date }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Financial Details Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Financial Details</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Profit Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($financial->profit_type) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Profit Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($financial->profit_rate, 4) }}%</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Process Fee</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->process_fee, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Amount Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Amount Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Total Facility Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->total_facility_amount, 2) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Utilization Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->utilization_amount, 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Outstanding Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->outstanding_amount, 2) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Monthly Interest</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->interest_monthly, 2) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Monthly Security Value</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">RM {{ number_format($financial->security_value_monthly, 2) }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Utilization Percentage</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $financial->total_facility_amount > 0 ? 
                                   number_format(($financial->utilization_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Associated Properties Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Associated Properties</h3>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        @if($financial->properties->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property Name</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Property Value</th>
                                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Financed Amount</th>
                                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Security Value</th>
                                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Valuation Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($financial->properties as $property)
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                    <a href="{{ route('property-m.show', $property) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        {{ $property->name }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-500">
                                                    {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-right text-gray-900">
                                                    RM {{ number_format($property->pivot->property_value ?? 0, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-right text-gray-900">
                                                    RM {{ number_format($property->pivot->financed_amount ?? 0, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-right text-gray-900">
                                                    RM {{ number_format($property->pivot->security_value ?? 0, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-center text-gray-500">
                                                    {{ $property->pivot->valuation_date ? date('d/m/Y', strtotime($property->pivot->valuation_date)) : 'N/A' }}
                                                </td>
                                            </tr>
                                            @if($property->pivot->remarks)
                                                <tr class="bg-gray-50">
                                                    <td class="px-4 py-2 text-sm text-gray-500 italic">Remarks:</td>
                                                    <td colspan="5" class="px-4 py-2 text-sm text-gray-500">{{ $property->pivot->remarks }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Property Financing Summary -->
                            <div class="mt-6 bg-gray-50 p-4 rounded-md">
                                <h4 class="text-md font-medium text-gray-700 mb-3">Property Financing Summary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="p-3 bg-white rounded-md shadow-sm">
                                        <div class="text-sm font-medium text-gray-500">Total Property Value</div>
                                        <div class="mt-1 text-lg font-semibold text-gray-900">
                                            RM {{ number_format($financial->properties->sum(function($property) { return $property->pivot->property_value ?? 0; }), 2) }}
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white rounded-md shadow-sm">
                                        <div class="text-sm font-medium text-gray-500">Total Financed Amount</div>
                                        <div class="mt-1 text-lg font-semibold text-gray-900">
                                            RM {{ number_format($financial->properties->sum(function($property) { return $property->pivot->financed_amount ?? 0; }), 2) }}
                                        </div>
                                    </div>
                                    <div class="p-3 bg-white rounded-md shadow-sm">
                                        <div class="text-sm font-medium text-gray-500">Total Security Value</div>
                                        <div class="mt-1 text-lg font-semibold text-gray-900">
                                            RM {{ number_format($financial->properties->sum(function($property) { return $property->pivot->security_value ?? 0; }), 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-md p-4 text-center">
                                <p class="text-gray-500">No properties are currently associated with this financial record.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Contact Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Facilities Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->facilities_agent }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Agent Contact</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->agent_contact ?: 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Valuer</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->valuer }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Financial Metrics Section -->
                <div class="hidden border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Financial Metrics</h3>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Utilization vs. Total Facility</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">RM {{ number_format($financial->utilization_amount, 2) }} / RM {{ number_format($financial->total_facility_amount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            {{ $financial->total_facility_amount > 0 ? 
                                               number_format(($financial->utilization_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Outstanding vs. Total Facility</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">RM {{ number_format($financial->outstanding_amount, 2) }} / RM {{ number_format($financial->total_facility_amount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            {{ $financial->total_facility_amount > 0 ? 
                                               number_format(($financial->outstanding_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Monthly Interest vs. Outstanding</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">RM {{ number_format($financial->interest_monthly, 2) }} / RM {{ number_format($financial->outstanding_amount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            {{ $financial->outstanding_amount > 0 ? 
                                               number_format(($financial->interest_monthly / $financial->outstanding_amount) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Security Value vs. Outstanding</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">RM {{ number_format($financial->security_value_monthly, 2) }} / RM {{ number_format($financial->outstanding_amount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            {{ $financial->outstanding_amount > 0 ? 
                                               number_format(($financial->security_value_monthly / $financial->outstanding_amount) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                    @if($financial->properties->count() > 0)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">Financed Amount vs. Property Value</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            RM {{ number_format($financial->properties->sum(function($property) { return $property->pivot->financed_amount ?? 0; }), 2) }} / 
                                            RM {{ number_format($financial->properties->sum(function($property) { return $property->pivot->property_value ?? 0; }), 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-900">
                                            @php
                                                $totalPropertyValue = $financial->properties->sum(function($property) { return $property->pivot->property_value ?? 0; });
                                                $totalFinancedAmount = $financial->properties->sum(function($property) { return $property->pivot->financed_amount ?? 0; });
                                            @endphp
                                            {{ $totalPropertyValue > 0 ? 
                                               number_format(($totalFinancedAmount / $totalPropertyValue) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Administrative Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Administrative Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $financial->approval_datetime ? date('d/m/Y h:i A', strtotime($financial->approval_datetime)) : 'Not yet approved' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">System Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $financial->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('property-m.index', $financial->portfolio) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('financial-m.edit', $financial) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Financial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>