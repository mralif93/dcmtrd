
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Compliance Covenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Action Buttons -->
                    <div class="mb-6 flex justify-between">
                        <a href="{{ route('compliance-covenants.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded-md">
                            &larr; Back to List
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('compliance-covenants.edit', $complianceCovenant) }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md">
                                Edit
                            </a>
                            <form action="{{ route('compliance-covenants.destroy', $complianceCovenant) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-md" 
                                        onclick="return confirm('Are you sure you want to delete this covenant?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Main Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Main Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">ID</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $complianceCovenant->id }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">Created At</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $complianceCovenant->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">Issuer Short Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $complianceCovenant->issuer_short_name }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">Financial Year End</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $complianceCovenant->financial_year_end }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $complianceCovenant->updated_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 rounded-md">
                                <p class="text-sm font-medium text-gray-500">Compliance Status</p>
                                <p class="mt-1">
                                    @if($complianceCovenant->isCompliant())
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Compliant
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Incomplete
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Document Information</h3>
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Document Type</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Audited Financial Statements</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->audited_financial_statements)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->audited_financial_statements ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Unaudited Financial Statements</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->unaudited_financial_statements)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->unaudited_financial_statements ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Compliance Certificate</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->compliance_certificate)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->compliance_certificate ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Finance Service Cover Ratio</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->finance_service_cover_ratio)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->finance_service_cover_ratio ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Annual Budget</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->annual_budget)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->annual_budget ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Computation of Finance to EBITDA</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->computation_of_finance_to_ebitda)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->computation_of_finance_to_ebitda ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Ratio Information on Use of Proceeds</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @if($complianceCovenant->ratio_information_on_use_of_proceeds)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Received</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $complianceCovenant->ratio_information_on_use_of_proceeds ?? 'N/A' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Missing Documents Section (only shown if not compliant) -->
                    @if(!$complianceCovenant->isCompliant())
                        <div class="mt-6 bg-yellow-50 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Warning Icon -->
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Missing Documents</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @if(!$complianceCovenant->audited_financial_statements)
                                                <li>Audited Financial Statements</li>
                                            @endif
                                            @if(!$complianceCovenant->unaudited_financial_statements)
                                                <li>Unaudited Financial Statements</li>
                                            @endif
                                            @if(!$complianceCovenant->compliance_certificate)
                                                <li>Compliance Certificate</li>
                                            @endif
                                            @if(!$complianceCovenant->finance_service_cover_ratio)
                                                <li>Finance Service Cover Ratio</li>
                                            @endif
                                            @if(!$complianceCovenant->annual_budget)
                                                <li>Annual Budget</li>
                                            @endif
                                            @if(!$complianceCovenant->computation_of_finance_to_ebitda)
                                                <li>Computation of Finance to EBITDA</li>
                                            @endif
                                            @if(!$complianceCovenant->ratio_information_on_use_of_proceeds)
                                                <li>Ratio Information on Use of Proceeds</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>