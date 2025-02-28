<!-- resources/views/admin/financial-reports/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Reports') }}
            </h2>
            <a href="{{ route('financial-reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Report
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

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('financial-reports.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                <select name="portfolio_id" id="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Portfolios</option>
                                    @foreach($portfolios as $id => $name)
                                        <option value="{{ $id }}" {{ request('portfolio_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                                <select name="report_type" id="report_type" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Types</option>
                                    <option value="Monthly" {{ request('report_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ request('report_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="Annual" {{ request('report_type') == 'Annual' ? 'selected' : '' }}>Annual</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Years</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="w-full md:w-1/3 md:self-end">
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Search
                                </button>
                                <a href="{{ route('financial-reports.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($summaryMetrics['total_revenue']) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Expenses</div>
                        <div class="text-2xl font-bold">${{ number_format($summaryMetrics['total_expenses']) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Net Income</div>
                        <div class="text-2xl font-bold">${{ number_format($summaryMetrics['net_income']) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Average Cap Rate</div>
                        <div class="text-2xl font-bold">{{ number_format($summaryMetrics['avg_cap_rate'], 2) }}%</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Metrics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Breakdown</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <canvas id="revenueChart" width="100%" height="200"></canvas>
                        </div>
                        <div class="col-span-2">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue Source</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Rental Income</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['rental_revenue']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_revenue'] > 0 ? ($summaryMetrics['rental_revenue'] / $summaryMetrics['total_revenue']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Other Income</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['other_revenue']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_revenue'] > 0 ? ($summaryMetrics['other_revenue'] / $summaryMetrics['total_revenue']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense Metrics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Breakdown</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <canvas id="expenseChart" width="100%" height="200"></canvas>
                        </div>
                        <div class="col-span-2">
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Maintenance</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['maintenance_expenses']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_expenses'] > 0 ? ($summaryMetrics['maintenance_expenses'] / $summaryMetrics['total_expenses']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Utilities</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['utility_expenses']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_expenses'] > 0 ? ($summaryMetrics['utility_expenses'] / $summaryMetrics['total_expenses']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Insurance</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['insurance_expenses']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_expenses'] > 0 ? ($summaryMetrics['insurance_expenses'] / $summaryMetrics['total_expenses']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Property Tax</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['property_tax']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_expenses'] > 0 ? ($summaryMetrics['property_tax'] / $summaryMetrics['total_expenses']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">Administrative</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($summaryMetrics['administrative_expenses']) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format(($summaryMetrics['total_expenses'] > 0 ? ($summaryMetrics['administrative_expenses'] / $summaryMetrics['total_expenses']) * 100 : 0), 1) }}%
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Reports List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Reports</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Income</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cap Rate</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reports as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('portfolios.show', $report->portfolio) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $report->portfolio->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->fiscal_period }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->report_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->total_revenue) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->operating_expenses + $report->maintenance_expenses + $report->administrative_expenses + $report->utility_expenses + $report->insurance_expenses + $report->property_tax) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->net_income) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->net_operating_income) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($report->cap_rate, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('financial-reports.show', $report) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('financial-reports.edit', $report) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('financial-reports.export', $report) }}" class="text-green-600 hover:text-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('financial-reports.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center">No financial reports found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        @if(method_exists($reports, 'links'))
                            {{ $reports->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: ['Rental Income', 'Other Income'],
                datasets: [{
                    data: [
                        {{ $summaryMetrics['rental_revenue'] }}, 
                        {{ $summaryMetrics['other_revenue'] }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Revenue Sources'
                    }
                }
            }
        });

        // Expense Chart
        const expenseCtx = document.getElementById('expenseChart').getContext('2d');
        const expenseChart = new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: ['Maintenance', 'Utilities', 'Insurance', 'Property Tax', 'Administrative'],
                datasets: [{
                    data: [
                        {{ $summaryMetrics['maintenance_expenses'] }}, 
                        {{ $summaryMetrics['utility_expenses'] }},
                        {{ $summaryMetrics['insurance_expenses'] }},
                        {{ $summaryMetrics['property_tax'] }},
                        {{ $summaryMetrics['administrative_expenses'] }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Expense Categories'
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>