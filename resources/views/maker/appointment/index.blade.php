<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointments Management') }}
            </h2>
            <a href="{{ route('maker.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
                    <h3 class="text-lg font-medium text-gray-900">Appointments</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('appointment-m.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Appointment
                        </a>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('appointment-m.index') }}">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Row 1: Search (full width) -->
                            <div class="col-span-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                        placeholder="Search by party name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            <!-- Row 2: Portfolio and Status (2 columns) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Portfolio Filter -->
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                    <select name="portfolio_id" id="portfolio_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">All Portfolios</option>
                                        @foreach($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" @selected(request('portfolio_id') == $portfolio->id)>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" @selected(request('status') == $status)>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Row 3: Date of Approval with single label -->
                            <div class="grid grid-cols-1 gap-4">
                                <label class="block text-sm font-medium text-gray-700">Date of Approval</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Day -->
                                    <div>
                                        <select name="day" id="day" 
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">All Days</option>
                                            @for($i = 1; $i <= 31; $i++)
                                                @php
                                                    $formattedValue = $i < 10 ? '0'.$i : $i;
                                                @endphp
                                                <option value="{{ $formattedValue }}" @selected(request('day') == $formattedValue)>
                                                    {{ $formattedValue }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <!-- Month -->
                                    <div>
                                        <select name="month" id="month" 
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">All Months</option>
                                            @foreach(['01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', 
                                                    '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', 
                                                    '10' => 'October', '11' => 'November', '12' => 'December'] as $value => $name)
                                                <option value="{{ $value }}" @selected(request('month') == $value)>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- Year -->
                                    <div>
                                        <select name="year" id="year" 
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">All Years</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" @selected(request('year') == $year)>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 4: Filter Buttons -->
                            <div class="flex justify-end space-x-2">
                                <button type="submit" id="filter-button"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Filter
                                </button>

                                @if(request()->anyFilled(['portfolio_id', 'status', 'year', 'month', 'day', 'search']))
                                    <a href="{{ route('appointment-m.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Appointments Table -->
                <div class="overflow-x-auto border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Approval</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Amount (RM)</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appointment->portfolio->portfolio_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appointment->party_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $appointment->date_of_approval->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $appointment->estimated_amount ? number_format($appointment->estimated_amount, 2) : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ match(strtolower($appointment->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('appointment-m.show', $appointment) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('appointment-m.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($appointments->count() === 0)
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No appointments found.</div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $appointments->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-search JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit on dropdown change
            const autoSubmitFilters = document.querySelectorAll('#portfolio_id, #status, #year, #month, #day');
            
            autoSubmitFilters.forEach(filter => {
                filter.addEventListener('change', function() {
                    // Show loading state on the filter button
                    const filterButton = document.getElementById('filter-button');
                    const originalButtonHTML = filterButton.innerHTML;
                    filterButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Applying...';
                    filterButton.disabled = true;
                    
                    // Submit form
                    this.closest('form').submit();
                });
            });
            
            // Debounced search for text input
            const searchInput = document.getElementById('search');
            let searchTimeout;
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    
                    // Only trigger search if the user has typed at least 2 characters or cleared the input
                    if (this.value.length >= 2 || this.value.length === 0) {
                        searchTimeout = setTimeout(() => {
                            // Show loading state
                            const filterButton = document.getElementById('filter-button');
                            filterButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Searching...';
                            filterButton.disabled = true;
                            
                            // Submit form
                            this.closest('form').submit();
                        }, 500); // Wait 500ms after user stops typing
                    }
                });
            }
            
            // Focus search input on page load if empty
            if (searchInput && searchInput.value === '') {
                searchInput.focus();
            }
        });
    </script>
</x-app-layout>