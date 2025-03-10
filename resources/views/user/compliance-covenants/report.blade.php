<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compliance Covenants Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Compliance Status Report</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('compliance-covenants.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back
                        </a>
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200 print:hidden">
                    <form method="GET" action="{{ route('compliance-covenants.report') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Issuer Filter -->
                            <div>
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Issuer</label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                       value="{{ request('issuer_short_name') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Search issuer...">
                            </div>

                            <!-- Financial Year End Filter -->
                            <div>
                                <label for="financial_year_end" class="block text-sm font-medium text-gray-700">Financial Year End</label>
                                <input type="text" name="financial_year_end" id="financial_year_end" 
                                       value="{{ request('financial_year_end') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="e.g. 31 Dec 2024">
                            </div>

                            <!-- Compliance Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Compliance Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="compliant" @selected(request('status') === 'compliant')>Compliant</option>
                                    <option value="non_compliant" @selected(request('status') === 'non_compliant')>Non-Compliant</option>
                                </select>
                            </div>

                            <!-- Generate Report Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <!-- Total Covenants Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Covenants</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_covenants }}</dd>
                            </div>
                        </div>

                        <!-- Compliant Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Compliant</dt>
                                <dd class="mt-1 text-3xl font-semibold text-green-600">{{ $compliant_covenants }}</dd>
                            </div>
                        </div>

                        <!-- Non-Compliant Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Non-Compliant</dt>
                                <dd class="mt-1 text-3xl font-semibold text-red-600">{{ $non_compliant_covenants }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Report Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Financial Year End</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Missing Documents</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($covenants as $covenant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $covenant->issuer_short_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $covenant->financial_year_end }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                        $covenant->isCompliant() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    }}">
                                        {{ $covenant->isCompliant() ? 'Compliant' : 'Non-Compliant' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if(!$covenant->isCompliant())
                                            <ul class="list-disc pl-5">
                                                @foreach($covenant->getMissingDocuments() as $document)
                                                    <li>{{ $document }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-green-600">All documents submitted</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium print:hidden">
                                    <a href="{{ route('compliance-covenants.show', $covenant) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No compliance covenants found for the selected criteria.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Report Footer -->
                <div class="px-4 py-6 sm:px-6 print:mt-8">
                    <div class="text-sm text-gray-500 print:border-t print:pt-4">
                        <p>Report generated on: {{ now()->format('d/m/Y H:i') }}</p>
                        <p>Filters applied: 
                            @if(request('issuer_short_name') || request('financial_year_end') || request('status'))
                                @if(request('issuer_short_name'))
                                    Issuer: {{ request('issuer_short_name') }}
                                @endif
                                @if(request('financial_year_end'))
                                    Financial Year End: {{ request('financial_year_end') }}
                                @endif
                                @if(request('status'))
                                    Status: {{ ucfirst(request('status')) }}
                                @endif
                            @else
                                None
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6 print:hidden">
                    {{ $covenants->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                font-size: 12px;
            }
            .print\:hidden {
                display: none !important;
            }
            .print\:border-t {
                border-top-width: 1px;
            }
            .print\:pt-4 {
                padding-top: 1rem;
            }
            .print\:mt-8 {
                margin-top: 2rem;
            }
            h2, h3 {
                font-size: 16px;
                font-weight: bold;
            }
        }
    </style>
</x-app-layout>