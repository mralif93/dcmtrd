<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Record Details') }}
            </h2>
            <a href="{{ route('financials-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                    <h3 class="text-lg font-medium text-gray-900">{{ $financial->purpose }}</h3>
                    <div>
                        <a href="{{ route('financials-info.edit', $financial->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 mr-2">
                            Edit
                        </a>
                        <form action="{{ route('financials-info.destroy', $financial->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this financial record?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Basic Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('portfolios-info.show', $financial->portfolio->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $financial->portfolio->portfolio_name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bank</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->bank->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Financial Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->financialType->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $financial->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($financial->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($financial->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Financial Details</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->purpose }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tenure</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->tenure }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Installment Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->installment_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Profit Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->profit_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Profit Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->profit_rate, 4) }}%</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Process Fee</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->process_fee, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Amount Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Facility Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->total_facility_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Utilization Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->utilization_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Outstanding Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->outstanding_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Monthly Interest</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->interest_monthly, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Monthly Security Value</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($financial->security_value_monthly, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Utilization Percentage</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $financial->total_facility_amount > 0 ? 
                                   number_format(($financial->utilization_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Agent Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facilities Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->facilities_agent }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Agent Contact</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->agent_contact ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Valuer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->valuer }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Portfolio Information</h4>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->portfolio->portfolio_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $financial->portfolio->portfolioType->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Portfolio Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $financial->portfolio->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($financial->portfolio->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Financial Metrics</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Utilization vs. Total Facility</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">{{ number_format($financial->utilization_amount, 2) }} / {{ number_format($financial->total_facility_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">
                                        {{ $financial->total_facility_amount > 0 ? 
                                           number_format(($financial->utilization_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Outstanding vs. Total Facility</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">{{ number_format($financial->outstanding_amount, 2) }} / {{ number_format($financial->total_facility_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">
                                        {{ $financial->total_facility_amount > 0 ? 
                                           number_format(($financial->outstanding_amount / $financial->total_facility_amount) * 100, 2) : 0 }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Monthly Interest vs. Outstanding</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">{{ number_format($financial->interest_monthly, 2) }} / {{ number_format($financial->outstanding_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">
                                        {{ $financial->outstanding_amount > 0 ? 
                                           number_format(($financial->interest_monthly / $financial->outstanding_amount) * 100, 2) : 0 }}%
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Security Value vs. Outstanding</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">{{ number_format($financial->security_value_monthly, 2) }} / {{ number_format($financial->outstanding_amount, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-900">
                                        {{ $financial->outstanding_amount > 0 ? 
                                           number_format(($financial->security_value_monthly / $financial->outstanding_amount) * 100, 2) : 0 }}%
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>