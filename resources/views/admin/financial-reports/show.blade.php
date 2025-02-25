<!-- resources/views/admin/financial-reports/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $financialReport->portfolio->name }} - {{ $financialReport->fiscal_period }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('financial-reports.edit', $financialReport) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Report
                </a>
                <a href="{{ route('financial-reports.export', $financialReport) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export CSV
                </a>
                <a href="{{ route('financial-reports.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Reports
                </a>
            </div>
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

            <!-- Report Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Portfolio</div>
                                <div>
                                    <a href="{{ route('portfolios.show', $financialReport->portfolio) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $financialReport->portfolio->name }}
                                    </a>
                                </div>
                                
                                <div class="text-sm text-gray-500">Report Type</div>
                                <div>{{ $financialReport->report_type }}</div>
                                
                                <div class="text-sm text-gray-500">Fiscal Period</div>
                                <div>{{ $financialReport->fiscal_period }}</div>
                                
                                <div class="text-sm text-gray-500">Report Date</div>
                                <div>{{ $financialReport->report_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="font-medium text-gray-700 mb-2">Performance Snapshot</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Occupancy Rate</div>
                                <div>{{ number_format($financialReport->occupancy_rate, 1) }}%</div>
                                
                                <div class="text-sm text-gray-500">Cap Rate</div>
                                <div>{{ number_format($financialReport->cap_rate, 2) }}%</div>
                                
                                <div class="text-sm text-gray-500">ROI</div>
                                <div>{{ number_format($financialReport->roi, 2) }}%</div>
                                
                                <div class="text-sm text-gray-500">Debt Ratio</div>
                                <div>{{ number_format($financialReport->debt_ratio, 2) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($financialReport->total_revenue, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Expenses</div>
                        <div class="text-2xl font-bold">${{ number_format(
                            $financialReport->operating_expenses + 
                            $financialReport->maintenance_expenses + 
                            $financialReport->administrative_expenses + 
                            $financialReport->utility_expenses + 
                            $financialReport->insurance_expenses + 
                            $financialReport->property_tax, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Net Operating Income</div>
                        <div class="text-2xl font-bold">${{ number_format($financialReport->net_operating_income, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Net Income</div>
                        <div class="text-2xl font-bold">${{ number_format($financialReport->net_income, 2) }}</div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Revenue Breakdown -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Breakdown</h3>
                        <canvas id="revenueChart" width="100%" height="250"></canvas>
                        
                        <div class="mt-4">
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
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->rental_revenue, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $financialReport->total_revenue > 0 ? number_format(($financialReport->rental_revenue / $financialReport->total_revenue) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Other Income</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->other_revenue, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $financialReport->total_revenue > 0 ? number_format(($financialReport->other_revenue / $financialReport->total_revenue) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($financialReport->total_revenue, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">100%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Expense Breakdown -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Breakdown</h3>
                        <canvas id="expenseChart" width="100%" height="250"></canvas>
                        
                        <div class="mt-4">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $totalExpenses = $financialReport->operating_expenses + 
                                                         $financialReport->maintenance_expenses + 
                                                         $financialReport->administrative_expenses + 
                                                         $financialReport->utility_expenses + 
                                                         $financialReport->insurance_expenses + 
                                                         $financialReport->property_tax;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Operating</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->operating_expenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->operating_expenses / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Maintenance</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->maintenance_expenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->maintenance_expenses / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Administrative</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->administrative_expenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->administrative_expenses / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Utilities</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->utility_expenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->utility_expenses / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Insurance</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->insurance_expenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->insurance_expenses / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">Property Tax</td>
                                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($financialReport->property_tax, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $totalExpenses > 0 ? number_format(($financialReport->property_tax / $totalExpenses) * 100, 1) : 0 }}%
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($totalExpenses, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">100%</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Details and Metrics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Revenue and Income -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Revenue & Income</h4>
                            <table class="min-w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Rental Revenue</td>
                                        <td class="py-2 text-right">${{ number_format($financialReport->rental_revenue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Other Revenue</td>
                                        <td class="py-2 text-right">${{ number_format($financialReport->other_revenue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm font-medium">Total Revenue</td>
                                        <td class="py-2 text-right font-medium">${{ number_format($financialReport->total_revenue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Total Expenses</td>
                                        <td class="py-2 text-right text-red-500">-${{ number_format($totalExpenses, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm font-medium">Net Operating Income (NOI)</td>
                                        <td class="py-2 text-right font-medium">${{ number_format($financialReport->net_operating_income, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Debt Service</td>
                                        <td class="py-2 text-right text-red-500">-${{ number_format($financialReport->debt_service, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Capital Expenditures</td>
                                        <td class="py-2 text-right text-red-500">-${{ number_format($financialReport->capex, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm font-medium">Net Income</td>
                                        <td class="py-2 text-right font-medium">${{ number_format($financialReport->net_income, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm font-medium">Cash Flow</td>
                                        <td class="py-2 text-right font-medium">${{ number_format($financialReport->cash_flow, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Financial Metrics -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Financial Metrics</h4>
                            <table class="min-w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Cap Rate</td>
                                        <td class="py-2 text-right">{{ number_format($financialReport->cap_rate, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Return on Investment (ROI)</td>
                                        <td class="py-2 text-right">{{ number_format($financialReport->roi, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Occupancy Rate</td>
                                        <td class="py-2 text-right">{{ number_format($financialReport->occupancy_rate, 1) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Debt Ratio</td>
                                        <td class="py-2 text-right">{{ number_format($financialReport->debt_ratio, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Net Margin</td>
                                        <td class="py-2 text-right">{{ number_format($metrics['net_margin'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Expense Ratio</td>
                                        <td class="py-2 text-right">{{ number_format($metrics['expense_ratio'], 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Debt Service Coverage</td>
                                        <td class="py-2 text-right">
                                            @if(is_numeric($metrics['debt_service_coverage']))
                                                {{ number_format($metrics['debt_service_coverage'], 2) }}x
                                            @else
                                                {{ $metrics['debt_service_coverage'] }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Period Comparison (if available) -->
                        @if($previousPeriod)
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Comparison to Previous {{ $financialReport->report_type }}</h4>
                            <table class="min-w-full">
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Revenue Change</td>
                                        <td class="py-2 text-right 
                                            {{ $changes['revenue'] > 0 ? 'text-green-600' : ($changes['revenue'] < 0 ? 'text-red-600' : '') }}">
                                            {{ number_format($changes['revenue'], 1) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Expense Change</td>
                                        <td class="py-2 text-right 
                                            {{ $changes['expenses'] < 0 ? 'text-green-600' : ($changes['expenses'] > 0 ? 'text-red-600' : '') }}">
                                            {{ number_format($changes['expenses'], 1) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">NOI Change</td>
                                        <td class="py-2 text-right 
                                            {{ $changes['noi'] > 0 ? 'text-green-600' : ($changes['noi'] < 0 ? 'text-red-600' : '') }}">
                                            {{ number_format($changes['noi'], 1) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Net Income Change</td>
                                        <td class="py-2 text-right 
                                            {{ $changes['net_income'] > 0 ? 'text-green-600' : ($changes['net_income'] < 0 ? 'text-red-600' : '') }}">
                                            {{ number_format($changes['net_income'], 1) }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Occupancy Change</td>
                                        <td class="py-2 text-right 
                                            {{ $changes['occupancy'] > 0 ? 'text-green-600' : ($changes['occupancy'] < 0 ? 'text-red-600' : '') }}">
                                            {{ number_format($changes['occupancy'], 1) }} points
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 text-sm text-gray-500">Previous Period</td>
                                        <td class="py-2 text-right">
                                            <a href="{{ route('financial-reports.show', $previousPeriod) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $previousPeriod->fiscal_period }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                        {{ $financialReport->rental_revenue }}, 
                        {{ $financialReport->other_revenue }}
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
                labels: ['Operating', 'Maintenance', 'Administrative', 'Utilities', 'Insurance', 'Property Tax'],
                datasets: [{
                    data: [
                        {{ $financialReport->operating_expenses }}, 
                        {{ $financialReport->maintenance_expenses }},
                        {{ $financialReport->administrative_expenses }},
                        {{ $financialReport->utility_expenses }},
                        {{ $financialReport->insurance_expenses }},
                        {{ $financialReport->property_tax }}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
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