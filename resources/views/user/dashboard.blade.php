<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            
            <!-- Back Button -->
            <a href="{{ route('main') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </x-slot>

    <!-- Default message when no section is selected -->
    <div id="default-message" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Welcome to the Dashboard') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Please select a section from the welcome page to view its content.') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->hasPermission('DCMTRD'))
    <div class="hidden py-12 dashboard-section" id="dcmtrd-section" data-section="dcmtrd">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="text-xl font-bold leading-tight text-gray-800">
                    {{ __('Debt Capital Market Trust Real Estate Department (DCMTRD)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Manage Data -->
                <x-dashboard-card
                    title="Manage Data"
                    icon="document-text"
                    :count="$managedDataCount ?? 0"
                    :href="route('upload.user.page')"
                    color="bg-blue-100"
                />

                <!-- Trustee Fees -->
                <x-dashboard-card
                    title="Trustee Fees"
                    icon="receipt-refund"
                    :count="$trusteeFeesCount"
                    :href="route('trustee-fees-info.index')"
                    color="bg-blue-100"
                />

                <!-- Compliance Covenants -->
                <x-dashboard-card
                    title="Compliance Covenants"
                    icon="document-check"
                    :count="$complianceCovenantCount"
                    :href="route('compliance-covenants-info.index')"
                    color="bg-blue-100"
                />

                <!-- Activity Daily -->
                <x-dashboard-card
                    title="Activity Daily"
                    icon="calendar"
                    :count="$activityDailyCount ?? 0"
                    href="#"
                    color="bg-blue-100"
                />

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
    </div>
    @endif

    @if(Auth::user()->hasPermission('REITS'))
    <div class="py-12 dashboard-section hidden" id="reits-section" data-section="reits">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Real Estate Investment Trusts (REITs)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Portfolios -->
                <x-dashboard-card
                    title="Portfolios"
                    icon="briefcase"
                    :count="$portfoliosCount"
                    :href="route('portfolios-info.index')"
                    color="bg-green-100"
                />

                <!-- Properties -->
                <x-dashboard-card
                    title="Properties"
                    icon="home"
                    :count="$propertiesCount"
                    :href="route('properties-info.index')"
                    color="bg-green-100"
                />

                <!-- Tenants -->
                <x-dashboard-card
                    title="Tenants"
                    icon="users"
                    :count="$tenantsCount"
                    :href="route('tenants-info.index')"
                    color="bg-green-100"
                />

                <!-- Leases -->
                <x-dashboard-card
                    title="Leases"
                    icon="document-text"
                    :count="$leasesCount"
                    :href="route('leases-info.index')"
                    color="bg-green-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-check"
                    :count="$checklistsCount"
                    :href="route('checklists-info.index')"
                    color="bg-green-100"
                />

                <!-- Financials -->
                <x-dashboard-card
                    title="Financials"
                    icon="currency-dollar"
                    :count="$financialsCount"
                    :href="route('financials-info.index')"
                    color="bg-green-100"
                />

                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="location-marker"
                    :count="$siteVisitsCount"
                    :href="route('site-visits-info.index')"
                    color="bg-green-100"
                />

                <!-- Documentation Items -->
                <x-dashboard-card
                    title="Documentation Items"
                    icon="document-duplicate"
                    :count="$documentationItemsCount"
                    :href="route('documentation-items-info.index')"
                    color="bg-green-100"
                />

                <!-- Tenant Approvals -->
                <x-dashboard-card
                    title="Tenant Approvals"
                    icon="shield-check"
                    :count="$tenantApprovalsCount"
                    :href="route('tenant-approvals-info.index')"
                    color="bg-green-100"
                />

                <!-- Condition Checks -->
                <x-dashboard-card
                    title="Condition Checks"
                    icon="clipboard-check"
                    :count="$conditionChecksCount"
                    :href="route('condition-checks-info.index')"
                    color="bg-green-100"
                />

                <!-- Property Improvements -->
                <x-dashboard-card
                    title="Property Improvements"
                    icon="home-modern"
                    :count="$propertyImprovementsCount"
                    :href="route('property-improvements-info.index')"
                    color="bg-green-100"
                />
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasPermission('LEGAL'))
    <div class="py-12 dashboard-section hidden" id="legal-section" data-section="legal">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Legal Department') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="location-marker"
                    :count="$siteVisitsCount"
                    :href="route('site-visits-info.index')"
                    color="bg-purple-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-check"
                    :count="$checklistsCount"
                    :href="route('checklists-info.index')"
                    color="bg-purple-100"
                />
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasPermission('COMPLIANCE'))
    <div class="py-12 dashboard-section hidden" id="compliance-section" data-section="compliance">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Compliance Management') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="location-marker"
                    :count="$siteVisitsCount"
                    :href="route('site-visits-info.index')"
                    color="bg-red-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-check"
                    :count="$checklistsCount"
                    :href="route('checklists-info.index')"
                    color="bg-red-100"
                />
            </div>
        </div>
    </div>
    @endif

    <!-- If the user has no permissions, show a message -->
    @if(!Auth::user()->hasPermission('DCMTRD') && !Auth::user()->hasPermission('REITS') && !Auth::user()->hasPermission('LEGAL') && !Auth::user()->hasPermission('COMPLIANCE'))
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('No Access') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('You do not have permission to access any modules.') }}</p>
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