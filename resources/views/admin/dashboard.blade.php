<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->hasPermission('DCMTRD'))
    <div class="hidden py-12 dashboard-section" id="dcmtrd-section" data-section="dcmtrd">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Debt Capital Market Trust Real Estate Department (DCMTRD)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Users -->
                <x-dashboard-card
                    title="Users"
                    icon="user-group"
                    :count="$usersCount"
                    :href="route('users.index')"
                    color="bg-blue-100"
                />

                <!-- Issuers -->
                <x-dashboard-card
                    title="Issuers"
                    icon="office-building"
                    :count="$issuersCount"
                    :href="route('issuers.index')"
                    color="bg-blue-100"
                />

                <!-- Bonds -->
                <x-dashboard-card
                    title="Bonds"
                    icon="banknotes"
                    :count="$bondsCount"
                    :href="route('bonds.index')"
                    color="bg-blue-100"
                />

                <!-- Rating Movements -->
                <x-dashboard-card
                    title="Rating Movements"
                    icon="trending-up"
                    :count="$ratingMovementsCount"
                    :href="route('rating-movements.index')"
                    color="bg-blue-100"
                />

                <!-- Payment Schedules -->
                <x-dashboard-card
                    title="Payment Schedules"
                    icon="currency-dollar"
                    :count="$paymentSchedulesCount"
                    :href="route('payment-schedules.index')"
                    color="bg-blue-100"
                />

                <!-- Redemptions -->
                <x-dashboard-card
                    title="Redemptions"
                    icon="arrow-path"
                    :count="$redemptionsCount"
                    :href="route('redemptions.index')"
                    color="bg-blue-100"
                />

                <!-- Call Schedules -->
                <x-dashboard-card
                    title="Call Schedules"
                    icon="phone-outgoing"
                    :count="$callSchedulesCount"
                    :href="route('call-schedules.index')"
                    color="bg-blue-100"
                />

                <!-- Lockout Periods -->
                <x-dashboard-card
                    title="Lockout Periods"
                    icon="lock-closed"
                    :count="$lockoutPeriodsCount"
                    :href="route('lockout-periods.index')"
                    color="bg-blue-100"
                />

                <!-- Trading Activities -->
                <x-dashboard-card
                    title="Trading Activities"
                    icon="chart-bar"
                    :count="$tradingActivitiesCount"
                    :href="route('trading-activities.index')"
                    color="bg-blue-100"
                />

                <!-- Announcements -->
                <x-dashboard-card
                    title="Announcements"
                    icon="megaphone"
                    :count="$announcementsCount"
                    :href="route('announcements.index')"
                    color="bg-blue-100"
                />

                <!-- Facility Information -->
                <x-dashboard-card
                    title="Facility Information"
                    icon="information-circle"
                    :count="$facilityInformationsCount"
                    :href="route('facility-informations.index')"
                    color="bg-blue-100"
                />

                <!-- Related Documents & Financials -->
                <x-dashboard-card
                    title="Related Documents & Financials"
                    icon="folder-open"
                    :count="$relatedDocumentsCount"
                    :href="route('related-documents.index')"
                    color="bg-blue-100"
                />

                <!-- Charts -->
                <x-dashboard-card
                    title="Charts"
                    icon="presentation-chart-line"
                    :count="$chartsCount"
                    :href="route('charts.index')"
                    color="bg-blue-100"
                />

                <!-- Trustee Fees -->
                <x-dashboard-card
                    title="Trustee Fees"
                    icon="receipt-refund"
                    :count="$trusteeFeesCount"
                    :href="route('trustee-fees.index')"
                    color="bg-blue-100"
                />

                <!-- Compliance Covenants -->
                <x-dashboard-card
                    title="Compliance Covenants"
                    icon="document-check"
                    :count="$complianceCovenantCount"
                    :href="route('compliance-covenants.index')"
                    color="bg-blue-100"
                />

                <!-- Activity Daily -->
                <x-dashboard-card
                    title="Activity Daily"
                    icon="calendar"
                    :count="$activityDailyCount ?? 0"
                    :href="route('activity-diaries.index')"
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
    <div class="hidden py-12 dashboard-section" id="reits-section" data-section="reits">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Real Estate Investment Trusts (REITs)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Portfolio Types -->
                <x-dashboard-card
                    title="Portfolio Types"
                    icon="collection"
                    :count="$portfolioTypesCount"
                    :href="route('portfolio-types.index')"
                    color="bg-green-100"
                />

                <!-- Banks -->
                <x-dashboard-card
                    title="Banks"
                    icon="bank"
                    :count="$banksCount"
                    :href="route('banks.index')"
                    color="bg-green-100"
                />

                <!-- Financial Types -->
                <x-dashboard-card
                    title="Financial Types"
                    icon="chart-pie"
                    :count="$financialTypesCount"
                    :href="route('financial-types.index')"
                    color="bg-green-100"
                />

                <!-- Portfolios -->
                <x-dashboard-card
                    title="Portfolios"
                    icon="briefcase"
                    :count="$portfoliosCount"
                    :href="route('portfolios.index')"
                    color="bg-green-100"
                />

                <!-- Properties -->
                <x-dashboard-card
                    title="Properties"
                    icon="home"
                    :count="$propertiesCount"
                    :href="route('properties.index')"
                    color="bg-green-100"
                />

                <!-- Tenants -->
                <x-dashboard-card
                    title="Tenants"
                    icon="users"
                    :count="$tenantsCount"
                    :href="route('tenants.index')"
                    color="bg-green-100"
                />

                <!-- Leases -->
                <x-dashboard-card
                    title="Leases"
                    icon="document-text"
                    :count="$leasesCount"
                    :href="route('leases.index')"
                    color="bg-green-100"
                />

                <!-- Financials -->
                <x-dashboard-card
                    title="Financials"
                    icon="currency-dollar"
                    :count="$financialsCount"
                    :href="route('financials.index')"
                    color="bg-green-100"
                />

                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="location-marker"
                    :count="$siteVisitsCount"
                    :href="route('site-visits.index')"
                    color="bg-green-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-check"
                    :count="$checklistsCount"
                    :href="route('checklists.index')"
                    color="bg-green-100"
                />

                <!-- Site Visit Logs -->
                <x-dashboard-card
                    title="Site Visit Logs"
                    icon="sparkles"
                    :count="$siteVisitLogsCount ?? 0"
                    :href="route('site-visit-logs.index')"
                    color="bg-green-100"
                />
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