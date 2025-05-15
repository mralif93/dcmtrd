<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Approver Dashboard') }}
            </h2>

            <!-- Dropdown Menu -->
            <div class="relative" x-data="{ open: false }" id="header-dropdown" style="display: none;">
                <button @click="open = !open" class="flex items-center text-gray-700 px-3 py-2 text-sm font-medium rounded-md bg-white border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none">
                    <span>{{ __('Menu') }}</span>
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" 
                    @click.away="open = false" 
                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95">
                    <div class="py-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Dashboard') }}
                        </a>

                        <!-- Trustee Fee -->
                        <a href="{{ route('trustee-fee-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Trustee Fee') }}
                        </a>

                        <!-- Compliance Covenant -->
                        <a href="{{ route('compliance-covenant-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Compliance Covenant') }}
                        </a>

                        <!-- Activity Diary -->
                        <a href="{{ route('activity-diary-a.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Activity Diary') }}
                        </a>

                        <!-- Audit Log -->
                        <a href="#" class="hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Audit Log') }}
                        </a>

                        <!-- Reports -->
                        <a href="#" class="hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Reports') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @if(Auth::user()->hasPermission('DCMTRD'))
    <div class="hidden py-12 dashboard-section" id="dcmtrd-section" data-section="dcmtrd">
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

            <div class="pb-6">
                <h2 class="text-xl font-bold leading-tight text-gray-800">
                    {{ __('Debt Capital Market Trust Real Estate Department (DCMTRD)') }}
                </h2>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Trustee Fees -->
                <x-dashboard-card
                    title="Trustee Fees"
                    icon="receipt-refund"
                    :count="$trusteeFeesCount ?? 0"
                    :href="route('trustee-fee-a.index')"
                    color="bg-blue-100"
                />

                <!-- Compliance Covenants -->
                <x-dashboard-card
                    title="Compliance Covenants"
                    icon="document-check"
                    :count="$complianceCovenantCount ?? 0"
                    :href="route('compliance-covenant-a.index')"
                    color="bg-blue-100"
                />

                <!-- Activity Diary -->
                <x-dashboard-card
                    title="Activity Diary"
                    icon="calendar"
                    :count="$activityDairyCount ?? 0"
                    :href="route('activity-diary-a.index')"
                    color="bg-blue-100"
                />

                <div class="hidden">
                <!-- Audit Log -->
                <x-dashboard-card
                    title="Audit Log"
                    icon="clipboard-list"
                    :count="$auditLogCount ?? 0"
                    href="#"
                    color="bg-blue-100"
                />

                <!-- Reports -->
                <x-dashboard-card
                    title="Reports"
                    icon="document"
                    :count="$reportsCount ?? 0"
                    href="#"
                    color="bg-blue-100"
                />
                </div>
            </div>

            <!-- Table Issuer -->
            <div class="bg-white shadow overflow-hidden rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">List of Issuers</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="hidden bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Issuer Name Search Field -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                       placeholder="Issuer name, short name, or reg. no...">
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Search
                                </button>
                                
                                @if(request('search') || request('status'))
                                    <a href="{{ route('issuers-info.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Issuer Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registration Number
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($issuers as $issuer)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <a href="{{ route('bond-a.details', $issuer) }}" class="cursor-pointer text-blue-600 hover:text-blue-900">
                                            {{ $issuer->issuer_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $issuer->registration_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $issuer->status == 'Active' ? 'bg-green-100 text-green-800' : 
                                            ($issuer->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($issuer->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $issuer->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('issuer-a.show', $issuer) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
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
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        No issuers found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($issuers->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $issuers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasPermission('REITS'))
    <div class="hidden py-12 dashboard-section" id="reits-section" data-section="reits">
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

            <div class="pb-6">
                <h2 class="text-xl font-bold leading-tight text-gray-800">
                    {{ __('Real Estate Investment Trusts (REITs)') }}
                </h2>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Properties -->
                <x-dashboard-card
                    title="Properties"
                    icon="office-building"
                    :count="$propertiesCount ?? 0"
                    :pendingCount="$pendingPropertiesCount ?? 0"
                    :href="route('property-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Financials -->
                <x-dashboard-card
                    title="Financials"
                    icon="document-chart-bar"
                    :count="$financialsCount ?? 0"
                    :pendingCount="$pendingFinancialsCount ?? 0"
                    :href="route('financial-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Tenants -->
                <x-dashboard-card
                    title="Tenants"
                    icon="users"
                    :count="$tenantsCount ?? 0"
                    :pendingCount="$pendingTenantsCount ?? 0"
                    :href="route('tenant-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Lease -->
                <x-dashboard-card
                    title="Lease"
                    icon="document-duplicate"
                    :count="$leaseCount ?? 0"
                    :pendingCount="$pendingLeaseCount ?? 0"
                    :href="route('lease-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Site Visit -->
                <x-dashboard-card
                    title="Site Visit"
                    icon="location-marker"
                    :count="$siteVisitCount ?? 0"
                    :pendingCount="$pendingSiteVisitCount ?? 0"
                    :href="route('site-visit-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Checklist -->
                <x-dashboard-card
                    title="Checklist"
                    icon="clipboard-check"
                    :count="$checklistCount ?? 0"
                    :pendingCount="$pendingChecklistCount ?? 0"
                    :href="route('checklist-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Appointment -->
                <x-dashboard-card
                    title="Appointment"
                    icon="calendar"
                    :count="$appointmentsCount ?? 0"
                    :pendingCount="$pendingAppointmentsCount ?? 0"
                    :href="route('appointment-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Approval Form -->
                <x-dashboard-card
                    title="Approval Form"
                    icon="document-check"
                    :count="$approvalFormsCount ?? 0"
                    :pendingCount="$pendingApprovalFormsCount ?? 0"
                    :href="route('approval-form-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Approval Property -->
                <x-dashboard-card
                    title="Approval Property"
                    icon="check-circle"
                    :count="$approvalPropertiesCount ?? 0"
                    :pendingCount="$pendingApprovalPropertiesCount ?? 0"
                    :href="route('approval-property-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />

                <!-- Activity Diary -->
                <x-dashboard-card
                    title="Activity Diary"
                    icon="clipboard-list"
                    :count="$siteVisitLogsCount ?? 0"
                    :pendingCount="$pendingSiteVisitLogsCount ?? 0"
                    :href="route('site-visit-log-a.main', ['tab' => 'all'])"
                    color="bg-green-100"
                />
            </div>

            <!-- Table Portfolio -->
            <div class="bg-white shadow overflow-hidden rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">List of Portfolios</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="hidden bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Issuer Name Search Field -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ old('search', request('search')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                       placeholder="Portfolio name..">
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Search
                                </button>
                                
                                @if(request('search') || request('status'))
                                    <a href="{{ route('maker.dashboard', ['section' => 'reits']) }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trust Deed</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annual Report</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Insurance</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valuation Report</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($portfolios as $portfolio)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <a href="{{ route('property-a.index', $portfolio) }}" class="cursor-pointer text-blue-600 hover:text-blue-900">
                                        {{ $portfolio->portfolio_name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if ($portfolio->trust_deed_document)
                                    <a href="{{ Storage::url($portfolio->trust_deed_document) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Download
                                    </a>
                                    @else
                                    <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if ($portfolio->annual_report)
                                    <a href="{{ Storage::url($portfolio->annual_report) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Download
                                    </a>
                                    @else
                                    <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if ($portfolio->insurance_document)
                                    <a href="{{ Storage::url($portfolio->insurance_document) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Download
                                    </a>
                                    @else
                                    <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if ($portfolio->valuation_report)
                                    <a href="{{ Storage::url($portfolio->valuation_report) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Download
                                    </a>
                                    @else
                                    <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($portfolio->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst($portfolio->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('portfolio-a.show', $portfolio) }}" class="text-indigo-600 hover:text-indigo-900" title="View">
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
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        No portfolio found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- JavaScript for handling section display -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the section parameter from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        
        // Initially hide the default message (will show it if no valid section is found)
        const defaultMessage = document.getElementById('default-message');
        
        // Select all section elements
        const sections = document.querySelectorAll('.dashboard-section');
        
        // If a section parameter is present
        if (section) {
            // Find the target section
            const targetSection = document.querySelector(`[data-section="${section}"]`);
            
            if (targetSection) {
                // Hide default message
                if (defaultMessage) {
                    defaultMessage.classList.add('hidden');
                }
                
                // Show only the target section
                targetSection.classList.remove('hidden');
            } else {
                // If no valid section was found, show the default message
                if (defaultMessage) {
                    defaultMessage.classList.remove('hidden');
                }
            }
        } else {
            // If no section parameter, show the default message
            if (defaultMessage) {
                defaultMessage.classList.remove('hidden');
            }
        }
    });
    </script>
</x-app-layout>
