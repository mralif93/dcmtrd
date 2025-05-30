<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Site Visit Logs Management') }}
            </h2>
            <a href="{{ route('approver.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Site Visit Logs</h3>
                </div>

                <!-- Status Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex px-6 space-x-6">
                        <a href="{{ route('site-visit-log-a.main', ['tab' => 'all'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            All Logs
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['all'] }}</span>
                        </a>
                        <a href="{{ route('site-visit-log-a.main', ['tab' => 'pending'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Pending
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['pending'] }}</span>
                        </a>
                        <a href="{{ route('site-visit-log-a.main', ['tab' => 'active'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'active' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Active
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['active'] }}</span>
                        </a>
                        <a href="{{ route('site-visit-log-a.main', ['tab' => 'rejected'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'rejected' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Rejected
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['rejected'] }}</span>
                        </a>
                        <a href="{{ route('site-visit-log-a.main', ['tab' => 'inactive'] + request()->except('page', 'tab')) }}" 
                           class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'inactive' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Inactive
                            <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $tabCounts['inactive'] }}</span>
                        </a>
                    </nav>
                </div>

                <!-- Search and filter options -->
                <div class="px-4 py-3 bg-gray-50 sm:px-6">
                    <form action="{{ route('site-visit-log-a.main') }}" method="GET" class="grid grid-cols-4 gap-4 md:grid-cols-5">
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        
                        <!-- Search input -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md" 
                                    placeholder="Purpose, property...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Portfolio dropdown -->
                        <div>
                            <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                            <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Portfolios</option>
                                @foreach($portfolios as $portfolio)
                                    <option value="{{ $portfolio->id }}" {{ request('portfolio_id') == $portfolio->id ? 'selected' : '' }}>
                                        {{ $portfolio->portfolio_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Property dropdown -->
                        <div>
                            <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                            <select id="property_id" name="property_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Properties</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" 
                                            data-portfolio="{{ $property->portfolio_id }}"
                                            {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Category dropdown -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    @if(!empty($category)) <!-- Skip the empty value we added -->
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Filter buttons -->
                        <div class="flex items-end space-x-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filter Results
                            </button>
                            <a href="{{ route('site-visit-log-a.main', ['tab' => $activeTab]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Site Visit Logs Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siteVisitLogs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $log->property->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $log->property->address ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $log->full_visit_date }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($log->purpose, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $log->category }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($log->status)) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-blue-100 text-blue-800'
                                        } }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @if($log->status == 'pending')
                                            <!-- Approve Button -->
                                            <form method="POST" action="{{ route('site-visit-log-a.approve', $log) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Approve Log">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Reject Button (opens modal) -->
                                            <button onclick="openRejectModal('{{ $log->id }}')" class="text-red-600 hover:text-red-900" title="Reject Log">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif

                                        <a href="{{ route('site-visit-log-a.details', $log) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($siteVisitLogs->count() === 0)
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No site visit logs found.</div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $siteVisitLogs->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Reject Site Visit Log</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Please provide a reason for rejecting this site visit log.</p>
                        </div>
                    </div>
                </div>
                
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="mt-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to our select elements
            const portfolioSelect = document.getElementById('portfolio_id');
            const propertySelect = document.getElementById('property_id');
            
            // Store all property options for filtering
            const propertyOptions = Array.from(propertySelect.options);
            
            // Function to filter properties based on selected portfolio
            function filterPropertiesByPortfolio() {
                const selectedPortfolioId = portfolioSelect.value;
                
                // If a portfolio is selected, only show properties from that portfolio
                if (selectedPortfolioId) {
                    propertyOptions.forEach(option => {
                        if (option.value === '' || option.dataset.portfolio === selectedPortfolioId) {
                            propertySelect.appendChild(option.cloneNode(true));
                        }
                    });
                } else {
                    // If no portfolio selected, show all properties
                    propertyOptions.forEach(option => {
                        propertySelect.appendChild(option.cloneNode(true));
                    });
                }
                
                // Restore the previously selected property if it's still available
                const previouslySelectedProperty = "{{ request('property_id') }}";
                if (previouslySelectedProperty) {
                    for (let i = 0; i < propertySelect.options.length; i++) {
                        if (propertySelect.options[i].value === previouslySelectedProperty) {
                            propertySelect.options[i].selected = true;
                            break;
                        }
                    }
                }
            }
            
            // Attach event listener to portfolio select
            portfolioSelect.addEventListener('change', filterPropertiesByPortfolio);
            
            // Initial filter on page load
            filterPropertiesByPortfolio();
        });
        
        function openRejectModal(logId) {
            document.getElementById('rejectForm').action = `/approver/site-visit-log/${logId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>