<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Notification Management') }}
            </h2>
            <a href="{{ route('approver.dashboard', ['section' => 'reits']) }}"
                class="inline-flex items-center px-4 py-2 text-xs font-medium tracking-widest text-gray-700 uppercase bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex px-6 space-x-6">
                            <button type="button" onclick="switchTab('lease')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'lease' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}" 
                                    id="tab-lease">
                                Lease
                                <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $activeLeasesCount ?? 0 }}</span>
                            </button>
                            
                            <button type="button" onclick="switchTab('siteVisit')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'siteVisit' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}" 
                                    id="tab-siteVisit">
                                Site Visits
                                <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $activeSiteVisitsCount ?? 0 }}</span>
                            </button>
                            
                            <button type="button" onclick="switchTab('siteVisitLog')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'siteVisitLog' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}" 
                                    id="tab-siteVisitLog">
                                Activity Diary
                                <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $activeSiteVisitLogsCount ?? 0 }}</span>
                            </button>
                            
                            <button type="button" onclick="switchTab('appointments')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'appointments' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}" 
                                    id="tab-appointments">
                                Appointments
                                <span class="ml-2 py-0.5 px-2.5 text-xs rounded-full bg-gray-100">{{ $activeAppointmentsCount ?? 0 }}</span>
                            </button>
                        </nav>
                    </div>

                    <!-- Lease Tab Content -->
                    <div id="content-lease" class="tab-content {{ $activeTab != 'lease' ? 'hidden' : '' }}">
                        <div class="overflow-x-auto p-6">
                            <table class="min-w-full divide-y divide-gray-200 bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($leases as $lease)
                                        @php
                                            // Calculate time remaining until lease end
                                            $endDate = \Carbon\Carbon::parse($lease->end_date);
                                            $now = \Carbon\Carbon::now();
                                            $daysRemaining = $now->diffInDays($endDate, false);

                                            // Format the time remaining text and badge color
                                            if ($daysRemaining < 0) {
                                                // Past date - no special formatting
                                                $timeRemaining = 'Past';
                                                $badgeClass = 'bg-gray-100 text-gray-500';
                                            } else {
                                                // Show total days remaining as integer (no decimals)
                                                $timeRemaining = (int)$daysRemaining . ' ' . Str::plural('day', (int)$daysRemaining);
                                                
                                                // Apply color coding based on urgency
                                                if ($daysRemaining == 0) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 7) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 30) {
                                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                } else {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $lease->tenant->property->portfolio->portfolio_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $lease->tenant->property->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $lease->tenant->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ date('d/m/Y', strtotime($lease->start_date)) }} - {{ date('d/m/Y', strtotime($lease->end_date)) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $timeRemaining }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ match(strtolower($lease->status)) {
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'active' => 'bg-green-100 text-green-800',
                                                        'inactive' => 'bg-gray-100 text-gray-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    } }}">
                                                    {{ ucfirst($lease->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('lease-a.details', $lease->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                                No leases found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination with tab preservation -->
                            <div class="mt-4">
                                {{ $leases->appends(['active_tab' => 'lease'])->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Site Visit Tab Content -->
                    <div id="content-siteVisit" class="tab-content {{ $activeTab != 'siteVisit' ? 'hidden' : '' }}">
                        <div class="overflow-x-auto p-6">
                            <table class="min-w-full divide-y divide-gray-200 bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit Date/Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($siteVisits as $siteVisit)
                                        @php
                                            // Parse date and time separately to avoid concatenation issues
                                            $visitDate = \Carbon\Carbon::parse($siteVisit->date_visit);
                                            $visitTime = \Carbon\Carbon::parse($siteVisit->time_visit);

                                            // Calculate time remaining until site visit
                                            $now = \Carbon\Carbon::now();
                                            $daysRemaining = $now->diffInDays($visitDate, false);

                                            // Format the time remaining text and badge color
                                            if ($daysRemaining < 0) {
                                                // Past date - no special formatting
                                                $timeRemaining = 'Past';
                                                $badgeClass = 'bg-gray-100 text-gray-500';
                                            } else {
                                                // Show total days remaining as integer (no decimals)
                                                $timeRemaining = (int)$daysRemaining . ' ' . Str::plural('day', (int)$daysRemaining);

                                                // Apply color coding based on urgency
                                                if ($daysRemaining == 0) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 7) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 30) {
                                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                } else {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $siteVisit->property->portfolio->portfolio_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $siteVisit->property->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ date('d/m/Y', strtotime($siteVisit->date_visit)) }} / {{ date('H:i A', strtotime($siteVisit->time_visit)) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $timeRemaining }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ match(strtolower($siteVisit->status)) {
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'active' => 'bg-green-100 text-green-800',
                                                        'inactive' => 'bg-gray-100 text-gray-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    } }}">
                                                    {{ ucfirst($siteVisit->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('site-visit-a.details', $siteVisit->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                No site visits found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination with tab preservation -->
                            <div class="mt-4">
                                {{ $siteVisits->appends(['active_tab' => 'siteVisit'])->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Site Visit Log Tab Content -->
                    <div id="content-siteVisitLog" class="tab-content {{ $activeTab != 'siteVisitLog' ? 'hidden' : '' }}">
                        <div class="overflow-x-auto p-6">
                            <table class="min-w-full divide-y divide-gray-200 bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($siteVisitLogs as $siteVisitLog)
                                        @php
                                            // Create a date from the components using the full visit date attribute
                                            $fullVisitDate = $siteVisitLog->getFullVisitDateAttribute();

                                            // Parse the date properly
                                            if ($fullVisitDate) {
                                                $visitDate = \Carbon\Carbon::createFromFormat('d/m/Y', $fullVisitDate);
                                            } else {
                                                // Fallback if the full date is not available
                                                $visitDate = \Carbon\Carbon::create(
                                                    $siteVisitLog->visit_year,
                                                    $siteVisitLog->visit_month,
                                                    $siteVisitLog->visit_day
                                                );
                                            }

                                            // Calculate days since the visit (for past visits)
                                            $now = \Carbon\Carbon::now();
                                            $daysRemaining = $now->diffInDays($visitDate, false);

                                            // Format the time remaining text and badge color
                                            if ($daysRemaining < 0) {
                                                // Past date - show as "Past"
                                                $timeRemaining = 'Past';
                                                $badgeClass = 'bg-gray-100 text-gray-500';
                                            } else {
                                                // Show total days remaining as integer (no decimals)
                                                $timeRemaining = (int)$daysRemaining . ' ' . Str::plural('day', (int)$daysRemaining);

                                                // Apply color coding based on urgency
                                                if ($daysRemaining == 0) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 7) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 30) {
                                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                } else {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $siteVisitLog->property->portfolio->portfolio_name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $siteVisitLog->property->name ?? 'Property #' . $siteVisitLog->property_id }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $siteVisitLog->getFullVisitDateAttribute() ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $timeRemaining }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ match(strtolower($siteVisitLog->status)) {
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'active' => 'bg-green-100 text-green-800',
                                                        'inactive' => 'bg-gray-100 text-gray-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    } }}">
                                                    {{ ucfirst($siteVisitLog->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('site-visit-log-a.details', $siteVisitLog->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                No activity diaries found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination with tab preservation -->
                            <div class="mt-4">
                                {{ $siteVisitLogs->appends(['active_tab' => 'siteVisitLog'])->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Appointments Tab Content -->
                    <div id="content-appointments" class="tab-content {{ $activeTab != 'appointments' ? 'hidden' : '' }}">
                        <div class="overflow-x-auto p-6">
                            <table class="min-w-full divide-y divide-gray-200 bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Portfolio</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($appointments as $appointment)
                                        @php
                                            // calculate time remaining
                                            $now = \Carbon\Carbon::now();
                                            $daysRemaining = $now->diffInDays($appointment->date_of_approval, false);

                                            // Format the time remaining text and badge color
                                            if ($daysRemaining < 0) {
                                                // Past date - show as "Past"
                                                $timeRemaining = 'Past';
                                                $badgeClass = 'bg-gray-100 text-gray-500';
                                            } else {
                                                // Show total days remaining as integer (no decimals)
                                                $timeRemaining = (int)$daysRemaining . ' ' . Str::plural('day', (int)$daysRemaining);

                                                // Apply color coding based on urgency
                                                if ($daysRemaining == 0) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 7) {
                                                    $badgeClass = 'bg-red-100 text-red-800';
                                                } elseif ($daysRemaining <= 30) {
                                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                } else {
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $appointment->portfolio->portfolio_name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $appointment->party_name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $appointment->date_of_approval ? $appointment->date_of_approval->format('d/m/Y') : 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                                    {{ $timeRemaining }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ match(strtolower($appointment->status ?? '')) {
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        'active' => 'bg-green-100 text-green-800',
                                                        'inactive' => 'bg-gray-100 text-gray-800',
                                                        default => 'bg-blue-100 text-blue-800'
                                                    } }}">
                                                    {{ ucfirst($appointment->status ?? 'Unknown') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <a href="{{ route('appointment-a.details', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                No appointments found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination with tab preservation -->
                            <div class="mt-4">
                                {{ $appointments->appends(['active_tab' => 'appointments'])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Switching JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL parameters for active tab
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('active_tab');

            // If active tab is specified in URL, switch to it
            if (activeTab) {
                switchTab(activeTab);
            }
        });

        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active styling from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show the selected tab content
            const selectedContent = document.getElementById(`content-${tabName}`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Add active styling to the selected tab button
            const selectedButton = document.getElementById(`tab-${tabName}`);
            if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500');
                selectedButton.classList.add('border-indigo-500', 'text-indigo-600');
            }

            // Update URL without page reload
            const url = new URL(window.location);
            url.searchParams.set('active_tab', tabName);
            window.history.replaceState({}, '', url);
        }
    </script>
</x-app-layout>
