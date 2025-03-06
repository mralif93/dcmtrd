<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->permission == 'DCMTRD')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Debt Capital Market Trust Real Estate Department (DCMTRD)') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Issuers -->
                <x-dashboard-card
                    title="Issuers"
                    icon="office-building"
                    :count="$issuersCount"
                    :href="route('issuers-info.index')"
                    color="bg-blue-100"
                />

                <!-- Bonds -->
                <x-dashboard-card
                    title="Bonds"
                    icon="banknotes"
                    :count="$bondsCount"
                    :href="route('bonds-info.index')"
                    color="bg-blue-100"
                />

                <!-- Rating Movements -->
                <x-dashboard-card
                    title="Rating Movements"
                    icon="trending-up"
                    :count="$ratingMovementsCount"
                    :href="route('rating-movements-info.index')"
                    color="bg-blue-100"
                />

                <!-- Payment Schedules -->
                <x-dashboard-card
                    title="Payment Schedules"
                    icon="currency-dollar"
                    :count="$paymentSchedulesCount"
                    :href="route('payment-schedules-info.index')"
                    color="bg-blue-100"
                />

                <!-- Redemptions -->
                <x-dashboard-card
                    title="Redemptions"
                    icon="arrow-path"
                    :count="$redemptionsCount"
                    :href="route('redemptions-info.index')"
                    color="bg-blue-100"
                />

                <!-- Call Schedules -->
                <x-dashboard-card
                    title="Call Schedules"
                    icon="phone-outgoing"
                    :count="$callSchedulesCount"
                    :href="route('call-schedules-info.index')"
                    color="bg-blue-100"
                />

                <!-- Lockout Periods -->
                <x-dashboard-card
                    title="Lockout Periods"
                    icon="lock-closed"
                    :count="$lockoutPeriodsCount"
                    :href="route('lockout-periods-info.index')"
                    color="bg-blue-100"
                />

                <!-- Trading Activities -->
                <x-dashboard-card
                    title="Trading Activities"
                    icon="chart-bar"
                    :count="$tradingActivitiesCount"
                    :href="route('trading-activities-info.index')"
                    color="bg-blue-100"
                />

                <!-- Announcements -->
                <x-dashboard-card
                    title="Announcements"
                    icon="megaphone"
                    :count="$announcementsCount"
                    :href="route('announcements-info.index')"
                    color="bg-blue-100"
                />

                <!-- Facility Information -->
                <x-dashboard-card
                    title="Facility Information"
                    icon="information-circle"
                    :count="$facilityInformationsCount"
                    :href="route('facility-informations-info.index')"
                    color="bg-blue-100"
                />

                <!-- Related Documents & Financials -->
                <x-dashboard-card
                    title="Related Documents & Financials"
                    icon="folder-open"
                    :count="$relatedDocumentsCount"
                    :href="route('related-documents-info.index')"
                    color="bg-blue-100"
                />

                <!-- Charts -->
                <x-dashboard-card
                    title="Charts"
                    icon="presentation-chart-line"
                    :count="$chartsCount"
                    :href="route('charts-info.index')"
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
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->permission == 'REITS')
    <div class="py-12">
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
                    color="bg-blue-100"
                />

                <!-- Properties -->
                <x-dashboard-card
                    title="Properties"
                    icon="home"
                    :count="$propertiesCount"
                    :href="route('properties-info.index')"
                    color="bg-blue-100"
                />

                <!-- Tenants -->
                <x-dashboard-card
                    title="Tenants"
                    icon="users"
                    :count="$tenantsCount"
                    :href="route('tenants-info.index')"
                    color="bg-blue-100"
                />

                <!-- Leases -->
                <x-dashboard-card
                    title="Leases"
                    icon="document-text"
                    :count="$leasesCount"
                    :href="route('leases-info.index')"
                    color="bg-blue-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-check"
                    :count="$checklistsCount"
                    :href="route('checklists-info.index')"
                    color="bg-blue-100"
                />

                <!-- Financials -->
                <x-dashboard-card
                    title="Financials"
                    icon="currency-dollar"
                    :count="$financialsCount"
                    :href="route('financials-info.index')"
                    color="bg-blue-100"
                />

                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="location-marker"
                    :count="$siteVisitsCount"
                    :href="route('site-visits-info.index')"
                    color="bg-blue-100"
                />

                <!-- Documentation Items -->
                <x-dashboard-card
                    title="Documentation Items"
                    icon="document-duplicate"
                    :count="$documentationItemsCount"
                    :href="route('documentation-items-info.index')"
                    color="bg-blue-100"
                />

                <!-- Tenant Approvals -->
                <x-dashboard-card
                    title="Tenant Approvals"
                    icon="shield-check"
                    :count="$tenantApprovalsCount"
                    :href="route('tenant-approvals-info.index')"
                    color="bg-blue-100"
                />

                <!-- Condition Checks -->
                <x-dashboard-card
                    title="Condition Checks"
                    icon="clipboard-check"
                    :count="$conditionChecksCount"
                    :href="route('condition-checks-info.index')"
                    color="bg-blue-100"
                />

                <!-- Property Improvements -->
                <x-dashboard-card
                    title="Property Improvements"
                    icon="home-modern"
                    :count="$propertyImprovementsCount"
                    :href="route('property-improvements-info.index')"
                    color="bg-blue-100"
                />
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
