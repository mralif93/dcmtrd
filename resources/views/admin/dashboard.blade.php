<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-6">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('DCMTRD') }}
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
            </div>
        </div>
    </div>

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
                    :href="route('portfolios.index')"
                    color="bg-green-100"
                />

                <!-- Properties -->
                <x-dashboard-card
                    title="Properties"
                    icon="home-modern"
                    :count="$propertiesCount"
                    :href="route('properties.index')"
                    color="bg-green-100"
                />

                <!-- Units -->
                <x-dashboard-card
                    title="Units"
                    icon="cube"
                    :count="$unitsCount"
                    :href="route('units.index')"
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

                <!-- Maintenance Records -->
                <x-dashboard-card
                    title="Maintenance Records"
                    icon="wrench-screwdriver"
                    :count="$maintenanceRecordsCount"
                    :href="route('maintenance-records.index')"
                    color="bg-green-100"
                />

                <!-- Financial Reports -->
                <x-dashboard-card
                    title="Financial Reports"
                    icon="document-chart-bar"
                    :count="$financialReportsCount"
                    :href="route('financial-reports.index')"
                    color="bg-green-100"
                />

                <!-- Checklists -->
                <x-dashboard-card
                    title="Checklists"
                    icon="clipboard-document-list"
                    :count="$checklistsCount"
                    :href="route('checklists.index')"
                    color="bg-green-100"
                />

                <!-- Checklist Items -->
                <x-dashboard-card
                    title="Checklist Items"
                    icon="clipboard-document-check"
                    :count="$checklistItemsCount"
                    :href="route('checklist-items.index')"
                    color="bg-green-100"
                />

                <!-- Checklist Responses -->
                <x-dashboard-card
                    title="Checklist Responses"
                    icon="clipboard-document"
                    :count="$checklistResponsesCount"
                    :href="route('checklist-responses.index')"
                    color="bg-green-100"
                />

                <!-- Site Visits -->
                <x-dashboard-card
                    title="Site Visits"
                    icon="map-pin"
                    :count="$siteVisitsCount"
                    :href="route('site-visits.index')"
                    color="bg-green-100"
                />
            </div>
        </div>
    </div>
</x-app-layout>